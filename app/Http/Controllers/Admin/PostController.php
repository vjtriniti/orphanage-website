<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class PostController extends Controller {
 public function index(){return view('admin.posts.index',['posts'=>Post::with('author')->latest()->paginate(15)]);}
 public function store(Request $r){$d=$this->validated($r);$d['slug']=Str::slug($d['title']).'-'.Str::lower(Str::random(5));$d['author_id']=auth()->id();if($r->hasFile('featured_image'))$d['featured_image']=$r->file('featured_image')->store('posts','public');Post::create($d);return back()->with('success','Post created.');}
 public function update(Request $r,Post $post){$d=$this->validated($r);if($r->hasFile('featured_image'))$d['featured_image']=$r->file('featured_image')->store('posts','public');$post->update($d);return back()->with('success','Post updated.');}
 public function destroy(Post $post){$post->delete();return back()->with('success','Post deleted.');}
 private function validated(Request $r){return $r->validate(['title'=>'required|max:180','excerpt'=>'nullable','content'=>'required','featured_image'=>'nullable|image|max:4096','seo_title'=>'nullable|max:180','meta_description'=>'nullable|max:300','status'=>'required|in:draft,published']);}
}
