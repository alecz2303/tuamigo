<?php 

class UserTableSeeder extends Seeder {

  public function run()
  {
    $user = new User;
    $user->username = 'arueda';
    $user->email = 'arueda@kerberosits.com';
    $user->password = 'ericko2303!@';
    $user->password_confirmation = 'ericko2303!@';
    $user->confirmation_code = md5(uniqid(mt_rand(), true));
    $user->confirmed = 1;

    if(! $user->save()) {
      Log::info('Unable to create user '.$user->username, (array)$user->errors());
    } else {
      Log::info('Created user "'.$user->username.'" <'.$user->email.'>');
    }
  }
}