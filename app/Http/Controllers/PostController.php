<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class PostController extends Controller
{
  public function show(Request $request, Post $post)
  {
    $postId = $post->id;

    $ip = $request->getClientIp();

    $isOk = Redis::set($ip, 'hits', 'NX', 'EX', 10);

    // Check if the user has spent at least 30 seconds on the page
    if ($isOk && $isOk->getPayload() === 'OK') {
      // Increment the Redis key for this post
      Redis::incrby("post:$postId:views", 1);

      // Update the view count in the database
      $postView = PostView::updateOrCreate(
        ['post_id' => $postId],
        ['views' => Redis::get("post:$postId:views")]
      );

      // Get the post and its view count
      $post = Post::leftJoin('post_view', 'posts.id', '=', 'post_view.post_id')
        ->select('posts.*', 'post_view.views')
        ->where('posts.id', $postId)
        ->first();
    }


    // Show the post and its view count
    return 'ok';
  }
}
