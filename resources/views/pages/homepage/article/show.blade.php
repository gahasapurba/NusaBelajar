@extends('layouts.homepage')
@section('title')
    Detail Artikel
@endsection
@section('content')
<section class="section blog-single">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1 col-md-12 col-12">
                <div class="single-inner">
                    <div class="post-thumbnils">
                        <img src="{{ Storage::url($item->thumbnail) }}" alt="Thumbnail">
                    </div>
                    <div class="post-details">
                        <div class="detail-inner">
                            <ul class="custom-flex post-meta">
                                <li>
                                    <a href="#">
                                        <i class="lni lni-calendar"></i>
                                        {{ $item->created_at->isoFormat('D MMMM Y') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="lni lni-comments"></i>
                                        {{ $article_comment_count }} Komentar
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="lni lni-eye"></i>
                                        {{ $item->view }} Kali Dilihat
                                    </a>
                                </li>
                            </ul>
                            <h2 class="post-title">
                                <a href="{{ route('article.show', $item->slug) }}">{{ $item->title }}</a>
                            </h2>
                            {!! $item->content !!}
                            @isset($item->quote)
                                <blockquote>
                                    <div class="icon">
                                        <i class="lni lni-quotation"></i>
                                    </div>
                                    <h4>"{{ $item->quote }}"</h4>
                                </blockquote>
                            @endisset
                            @isset($item->file)
                                <div class="post-tags-media">
                                    <div class="post-tags popular-tag-widget mb-xl-40">
                                        <h5 class="tag-title">File Artikel</h5>
                                        <div class="tags">
                                            <a href="{{ Storage::url($item->file) }}" target="_blank">Unduh File Artikel</a>
                                        </div>
                                    </div>
                                </div>
                            @endisset
                            <div class="post-tags-media">
                                <div class="post-tags popular-tag-widget mb-xl-40">
                                    <h5 class="tag-title">Tag Artikel</h5>
                                    <div class="tags">
                                        @foreach ($item->article_tags as $article_tag)
                                            <a href="{{ route('article.tag', $article_tag->slug) }}">{{ $article_tag->name }}</a>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="post-social-media">
                                    <h5 class="share-title">Bagikan Artikel</h5>
                                    <div class="addthis_inline_share_toolbox"></div>
                                </div>
                            </div>
                        </div>
                        <div class="post-comments">
                            <h3 class="comment-title">Komentar Artikel</h3>
                            <ul class="comments-list">
                                @forelse ($article_comments as $article_comment)
                                    <li>
                                        <div class="comment-img">
                                            @if (Str::startsWith($article_comment->article_comment_creator->avatar, 'upload/avatar/'))
                                                <img src="{{ Storage::url($article_comment->article_comment_creator->avatar) }}" alt="Profile Photo">
                                            @elseif (!$article_comment->article_comment_creator->avatar)
                                                <img src="https://ui-avatars.com/api/?name={{ $article_comment->article_comment_creator->name }}" alt="Profile Photo" />
                                            @else
                                                <img src="{{ $article_comment->article_comment_creator->avatar }}" alt="Profile Photo" />
                                            @endif
                                        </div>
                                        <div class="comment-desc">
                                            <div class="desc-top">
                                                <h6>{{ $article_comment->article_comment_creator->name }}</h6>
                                                <span class="date">{{ $article_comment->created_at->isoFormat('dddd, D MMMM Y, HH:mm:ss') }} ({{ $article_comment->created_at->diffForHumans() }})</span>
                                                <a href="{{ route('dashboard.article.comment.destroy', $hash->encodeHex($article_comment->id)) }}" class="reply-link text-danger"><i class="lni lni-reply"></i>Hapus</a>
                                            </div>
                                            {!! $article_comment->comment !!}
                                        </div>
                                        @isset($article_comment->file)
                                            <div class="post-tags-media">
                                                <div class="post-tags popular-tag-widget mt-4">
                                                    <div class="tags">
                                                        <a href="{{ Storage::url($article_comment->file) }}" target="_blank">Unduh File Komentar Artikel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endisset
                                    </li>
                                @empty
                                    <li>
                                        <div class="comment-desc">
                                            <p class="text-center">Tidak Ada Komentar</p>
                                        </div>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="comment-form">
                        <h3 class="comment-reply-title">Leave a comment</h3>
                        <form action="#" method="POST">
                        <div class="row">
                        <div class="col-lg-4 col-md-12 col-12">
                        <div class="form-box form-group">
                        <input type="text" name="#" class="form-control form-control-custom" placeholder="Your Name" />
                        </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                        <div class="form-box form-group">
                        <input type="email" name="#" class="form-control form-control-custom" placeholder="Your Email" />
                        </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                        <div class="form-box form-group">
                        <input type="email" name="#" class="form-control form-control-custom" placeholder="Your Subject" />
                        </div>
                        </div>
                        <div class="col-12">
                        <div class="form-box form-group">
                        <textarea name="#" rows="6" class="form-control form-control-custom" placeholder="Your Comments"></textarea>
                        </div>
                        </div>
                        <div class="col-12">
                        <div class="button">
                        <button type="submit" class="btn mouse-dir white-bg">Post Comment <span class="dir-part"></span></button>
                        </div>
                        </div>
                        </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection