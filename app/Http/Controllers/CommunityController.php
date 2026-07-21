<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommunityController extends Controller
{
    /**
     * Display the community page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data = [
            'posts' => $this->getPosts(),
            'groups' => $this->getGroups(),
            'leaderboard' => $this->getLeaderboard(),
        ];
        
        return view('pages.community.index', $data);
    }

    /**
     * Store a new post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'image' => 'nullable|image|max:5120',
        ]);
        
        // Save post
        // Post::create([
        //     'user_id' => auth()->id(),
        //     'content' => $request->content,
        //     'image' => $request->file('image')?->store('posts', 'public'),
        // ]);
        
        return redirect()->route('community.index')
            ->with('success', 'Post created successfully!');
    }

    /**
     * Like a post.
     *
     * @param  int  $postId
     * @return \Illuminate\Http\JsonResponse
     */
    public function like($postId)
    {
        // Toggle like
        // $post = Post::findOrFail($postId);
        // $liked = $post->likes()->toggle(auth()->id());
        
        return response()->json([
            'success' => true,
            'message' => 'Like toggled successfully'
        ]);
    }

    /**
     * Comment on a post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $postId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function comment(Request $request, $postId)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);
        
        // Save comment
        // Comment::create([
        //     'user_id' => auth()->id(),
        //     'post_id' => $postId,
        //     'content' => $request->comment,
        // ]);
        
        return redirect()->route('community.index')
            ->with('success', 'Comment added successfully!');
    }

    /**
     * Get posts.
     *
     * @return array
     */
    private function getPosts()
    {
        return [
            [
                'id' => 1,
                'user' => ['name' => 'John Smith', 'avatar' => 'https://ui-avatars.com/api/?name=John+Smith&background=10B981&color=fff'],
                'content' => 'Just completed my first 5k run! 🏃‍♂️ Feeling amazing!',
                'image' => 'https://images.unsplash.com/photo-1552674605-db6ffd4facb5?w=800&h=400&fit=crop',
                'likes' => 24,
                'comments' => 8,
                'time' => '2 hours ago',
                'liked' => false
            ],
            [
                'id' => 2,
                'user' => ['name' => 'Sarah Johnson', 'avatar' => 'https://ui-avatars.com/api/?name=Sarah+Johnson&background=3B82F6&color=fff'],
                'content' => 'New PR on deadlift today! 135kg x 5 reps 💪',
                'image' => null,
                'likes' => 18,
                'comments' => 5,
                'time' => '4 hours ago',
                'liked' => true
            ],
        ];
    }

    /**
     * Get groups.
     *
     * @return array
     */
    private function getGroups()
    {
        return [
            ['name' => 'HIIT Warriors', 'members' => 234, 'image' => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=400&h=300&fit=crop'],
            ['name' => 'Yoga Enthusiasts', 'members' => 189, 'image' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=400&h=300&fit=crop'],
            ['name' => 'Strength Training', 'members' => 321, 'image' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=400&h=300&fit=crop'],
        ];
    }

    /**
     * Get leaderboard.
     *
     * @return array
     */
    private function getLeaderboard()
    {
        return [
            ['rank' => 1, 'name' => 'Mike Chen', 'points' => 2850, 'avatar' => 'https://ui-avatars.com/api/?name=Mike+Chen&background=F97316&color=fff'],
            ['rank' => 2, 'name' => 'Emma Wilson', 'points' => 2700, 'avatar' => 'https://ui-avatars.com/api/?name=Emma+Wilson&background=10B981&color=fff'],
            ['rank' => 3, 'name' => 'David Kim', 'points' => 2550, 'avatar' => 'https://ui-avatars.com/api/?name=David+Kim&background=3B82F6&color=fff'],
        ];
    }
}