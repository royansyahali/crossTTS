<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Auth;
use DB;
use Redirect;
use Socialite;

use App\Models\TwitterUser;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Redirect the user to the Twitter authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('twitter')->redirect();
    }

    /**
     * Obtain the user information from Twitter.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $package_from_twitter = Socialite::driver('twitter')->user();
        if ($package_from_twitter){
            $twitter_user = TwitterUser::where('twitter_id', $package_from_twitter->id)->first();
            if (!$twitter_user){
                $twitter_user = new TwitterUser;
            }
            $twitter_user->twitter_id = $package_from_twitter->id;
            $twitter_user->name = $package_from_twitter->name;
            $twitter_user->screen_name = $package_from_twitter->nickname;
            $twitter_user->description = $package_from_twitter->user['description'];
            $twitter_user->utc_offset = $package_from_twitter->user['utc_offset'];
            if (@$package_from_twitter->user['profile_banner_url']){
                $twitter_user->profile_background_image_url = $package_from_twitter->user['profile_banner_url'];
            }
            $twitter_user->profile_image_url = $package_from_twitter->user['profile_image_url'];
            $twitter_user->updated_timestamp_utc = time();
            $twitter_user->created_timestamp_utc = time();
            $twitter_user->oauth_token = Input::get('oauth_token');
            $twitter_user->oauth_token_secret = Input::get('oauth_verifier');
            $twitter_user->save();
            $user = Auth::user();
            if ($user && $user->temporary == 1){
                Auth::logout();
            }
            $user = Auth::user();
            if ($user){
                $user->twitter_user_id = $twitter_user->id;
                $user->updated_timestamp_utc = time();
                $user->most_recent_ip = request()->ip();
                $user->save();
            }else{
                $user = User::where('twitter_user_id', $twitter_user->id)->first();
                if (!$user){
                    $user = new User;
                    $username = $twitter_user->screen_name;
                    $orig_username = $username;
                    $i=0;
                    $username_exists = User::where('username', $username)->first();
                    while ($username_exists){
                        $username = $orig_username."_".$i++;
                        $username_exists = User::where('username', $username)->first();
                    }
                    $user->username = $username;
                    $user->twitter_user_id = $twitter_user->id;
                    $user->name = $twitter_user->name;
                    $user->created_timestamp_utc = time();
                }
                $user->updated_timestamp_utc = time();
                $user->most_recent_ip = request()->ip();
                $user->save();
            }
            Auth::login($user);
            
            return view('auth/killwindow');
        }else{
            return abort(401, 'Apparently, Twitter didn\'t like you.');
        }
    }
    public function getKillWindow(){
        return view('auth/killwindow');
    }
    public function getMe(){
        $user = Auth::user();
        if ($user){
            return array(
                'logged_in' => true,
                'fullname' => $user->name,
                'twitter_handle' => $user->twitter->screen_name,
                'profile_background_image_url' => $user->twitter->profile_background_image_url,
                'profile_image_url' => $user->twitter->profile_image_url,
                'admin' => $user->admin,
                'user_id' => $user->id
            );
        }else{
            return array(
                'logged_in' => false,
            );
        }
    }
    public function getLogout(){
        Auth::logout();
        return;
    }
    
}
