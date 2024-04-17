<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;

use function App\Helpers\Error;

use App\Models\UserRelationship;
use App\Http\Controllers\Controller;
use function App\Helpers\Successful;

class UserRelationshipController extends Controller
{
  public function follow($followee_id)
  {
    $follower_id = auth()->user()->id;

    if ($followee_id == $follower_id) {
      return Error('User Can\'t follow themselves ', 400);
    }

    $user = auth()->user();

    $followees = $user->followees->map(function ($user) {
      return $user->only(['followee_id']);
    });

    if ($followees->contains('followee_id', $followee_id)) {
      return Error('You already follow this user', 400);
    }

    $user_relationship = new UserRelationship();
    $user_relationship->follower_id = $follower_id;
    $user_relationship->followee_id = $followee_id;

    $user_relationship->save();

    return Successful(201, 'You Followed This User');
  }

  public function unfollow($followee_id)
  {
    $follower_id = auth()->user()->id;

    $user = auth()->user();

    $followees = $user->followees->map(function ($user) {
      return $user->only(['followee_id']);
    });

    if (!$followees->contains('followee_id', $followee_id)) {
      return Error('You don\'t follow this user', 400);
    }

    UserRelationship::where('followee_id', $followee_id)
      ->where('follower_id', $follower_id)
      ->delete();
      return Successful(201, 'You Unfollowed This User');

  }

  public function userFollowees($user_id)
  {
    $user = User::find($user_id);
    $followees = $user->followees->map(function ($user) {
      return $user->only(['followee_id']);
    });

    return Successful(201, 'user followees', $followees);
  }

  public function userFollowers($user_id)
  {

    $user = User::find($user_id);
    $followers = $user->followers->map(function ($user) {
      return $user->only(['follower_id']);
    });

    return Successful(201, 'user followers', $followers);
  }
}
