@inject('markdown', 'Parsedown')
@php
// TODO: There should be a better place for this.
$markdown->setSafeMode(true);
@endphp

<div id="comment-{{ $comment->getKey() }}" class="text-xs lg:text-lg">

    <div class="inline-flex lg:gap-4 gap-1 w-full relative">
        <div class="">
            <img class="image rounded-full lg:w-20 lg:h-18 w-10"
                src="{{ \App\Models\User::AVATA[array_rand(\App\Models\User::AVATA, 1)] }}"
                alt="{{ $comment->commenter->name ?? $comment->guest_name }} Avatar">
        </div>
        <div class="bg-[#EAEAEA] w-full p-2 rounded-xl ">
            <div class="mt-0 mb-1 inline-flex gap-2">
                <b> {{ $comment->commenter->name ?? $comment->guest_name }} </b>
                <p class="bg-[#00ff6a] w-3 h-3 rounded-full lg:mt-1.5"></p>
                <small class="lg:mt-1">- {{ $comment->created_at->diffForHumans() }}</small>
            </div>
            <div class="break-words px-1 lg:px-4 w-11/12">
                <b>{{ $comment->child_id ? '[ ' . $comment->parent->commenter->name . ' ] - ' : '' }}</b>
                {!! $markdown->line($comment->comment) !!}
            </div>
        </div>

        <div
            class="bg-[#ffffff] px-1 py-1 rounded-full inline-flex gap-1 border border-[#37a0f7] absolute -bottom-3 right-1 hover:shadow-xl">
            <div id="sum_like_{{ $comment->getKey() }}"><i class="mt-0.5 fa-regular fa-thumbs-up"></i> 100</div>
        </div>
    </div>
    <div class="lg:ml-24 ml-10 ">
        <div>
            @can('like-comment', $comment)
                <button data-toggle="modal" data-target="#like-modal-{{ $comment->getKey() }}"
                        onclick="like({{ $comment->getKey() }})"
                        class="border text-[#0000FF] border-[#0000FF] w-12 lg:w-20 py-1 hover:shadow-2xl hover:bg-[#6db7e9] rounded-xl">
                    Like
                </button>
            @endcan
            @can('dislike-comment', $comment)
                <button data-toggle="modal" data-target="#deslike-modal-{{ $comment->getKey() }}"
                        onclick="deslike({{ $comment->getKey() }})"
                        class="border text-[#0000FF] border-[#0000FF] w-12 lg:w-20 py-1 hover:shadow-2xl hover:bg-[#6db7e9] rounded-xl">
                    <b>Dislike</b>
                </button>
            @endcan
            @can('reply-to-comment', $comment)
                <button onclick="show('reply-modal-{{ $comment->getKey() }}')" data-toggle="modal"
                        data-target="#reply-modal-{{ $comment->getKey() }}"
                        class="border border-[#000000] w-12 lg:w-20 py-1 hover:shadow-2xl hover:bg-[#dbd9d9] rounded-xl">@lang('comments::comments.reply')</button>
            @endcan
            @can('edit-comment', $comment)
                <button onclick="show('comment-modal-{{ $comment->getKey() }}')" data-toggle="modal"
                        data-target="#comment-modal-{{ $comment->getKey() }}"
                        class="border border-[#0000ff] w-12 lg:w-20 py-1 hover:shadow-2xl hover:bg-[#658fbe] rounded-xl">@lang('comments::comments.edit')</button>
            @endcan
            @can('delete-comment', $comment)
                <a href="{{ route('comments.destroy', $comment->getKey()) }}"
                   onclick="event.preventDefault();document.getElementById('comment-delete-form-{{ $comment->getKey() }}').submit();">
                    <button
                        class="border border-[#ff0000] w-12 lg:w-20 py-1 hover:shadow-2xl hover:bg-[#e26e6e] rounded-xl">
                        @lang('comments::comments.delete')
                    </button>
                </a>
                <form id="comment-delete-form-{{ $comment->getKey() }}"
                      action="{{ route('comments.destroy', $comment->getKey()) }}" method="POST" style="display: none;">
                    @method('DELETE')
                    @csrf
                </form>
            @endcan
        </div>

        @can('edit-comment', $comment)
            <div class="hidden" id="comment-modal-{{ $comment->getKey() }}" tabindex="-1" role="dialog">
                <div class="my-2 w-full" role="document">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('comments.update', $comment->getKey()) }}">
                            @method('PUT')
                            @csrf
                            <h5 class="ml-4 my-2">@lang('comments::comments.edit_comment')</h5>
                            <div class="form-group">
                                <textarea required class="w-full rounded-2xl px-4 py-2 border" name="message" rows="3"
                                    placeholder="@lang('comments::comments.update_your_message_here')">{{ $comment->comment }}</textarea>
                            </div>
                            <button type="submit"
                                class="border text-white bg-[#5bc8d6] w-12 lg:w-20 py-1 hover:shadow-2xl hover:bg-[#98aca7] rounded-xl">@lang('comments::comments.update')</button>
                            <button type="button"
                                class="border border-[#000000] w-12 lg:w-20 py-1 hover:shadow-2xl hover:bg-[#98aca7] rounded-xl"
                                data-dismiss="modal">@lang('comments::comments.cancel')</button>
                        </form>
                    </div>
                </div>
            </div>
        @endcan

        @can('reply-to-comment', $comment)
            <div class="hidden" id="reply-modal-{{ $comment->getKey() }}" tabindex="-1" role="dialog">
                <div class="my-2 w-full" role="document">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('comments.reply', $comment->getKey()) }}">
                            @csrf
                            <h5 class="ml-4 my-2">@lang('comments::comments.reply_to_comment')</h5>
                            <div class="form-group">
                                <textarea required class="w-full rounded-2xl px-4 py-2 border" name="message" rows="3"
                                          placeholder="@lang('comments::comments.enter_your_message_here')"></textarea>
                            </div>
                            <button type="submit"
                                    class="border text-white bg-[#52ac7a] w-12 lg:w-20 py-1 hover:shadow-2xl hover:bg-[#98aca7] rounded-xl">@lang('comments::comments.reply')</button>
                            <button type="button"
                                    class="border border-[#000000] w-12 lg:w-20 py-1 hover:shadow-2xl hover:bg-[#98aca7] rounded-xl"
                                    data-dismiss="modal">@lang('comments::comments.cancel')</button>
                        </form>
                    </div>
                </div>
            </div>
        @endcan

        {{--    List liker--}}
        <div class="relative w-full text-center">
            <div class="my-2 mx-auto hidden absolute right-16 z-10" id="form">
                <div class="w-48 lg:w-96 h-36 lg:h-80 bg-[#f0f0f0] px-2 py-2 border shadow-sm rounded-lg overflow-auto">
                    <div class="inline-flex justify-between w-full border-b-2 border-[#121231]">
                        <p>All Like</p>
                    </div>
                    <div class="inline-flex gap-3 w-full mb-2">
                        <div class="w-full" id="list_liker">
                            {{--                            name liker--}}

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br/>
            <?php
            if (!isset($indentationLevel)) {
                $indentationLevel = 1;
            } else {
                $indentationLevel++;
            }
            ?>

        @if ($grouped_comments->has($comment->getKey()) && $indentationLevel <= $maxIndentationLevel)
            @foreach ($grouped_comments[$comment->getKey()] as $child)
                @include('comments::_comment', [
                    'comment' => $child,
                    'grouped_comments' => $grouped_comments,
                    'border' => $indentationLevel >= 1 ? 'border-l-2 border-l-red pl-3' : '',
                ])
            @endforeach
        @endif

    </div>
</div>

{{-- Recursion for children --}}
@if ($grouped_comments->has($comment->getKey()) && $indentationLevel > $maxIndentationLevel)
    {{--     TODO: Don't repeat code. Extract to a new file and include it. --}}
    @foreach ($grouped_comments[$comment->getKey()] as $child)
        @include('comments::_comment', [
            'comment' => $child,
            'grouped_comments' => $grouped_comments,
        ])
    @endforeach
@endif

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
<script type="text/javascript">
    function show(form_id) {
        document.getElementById(form_id).classList.toggle("hidden");
    }

    function like($id_comment) {
        $.ajax({
            type: "POST",
            url: '{{ route('like.store') }}',
            data: {
                liker_type: 'Laravelista\\Comments\\Comment',
                comment_id: $id_comment,
                _token: "{{ csrf_token() }}"
            },
            success: function (data) {
                if (data) {
                    location.reload();
                }
            },
            error: function (error) {
                alert(error);
            }
        });
    }

    function deslike($id_comment) {
        $.ajax({
            type: "POST",
            url: '{{ route('like.destroy') }}',
            data: {
                comment_id: $id_comment,
                _token: "{{ csrf_token() }}"
            },
            success: function (data) {
                if (data) {
                    location.reload();
                }
            },
            error: function (error) {
                alert(error);
            }
        });
    }

    totalLike();

    function totalLike() {
        $.ajax({
            type: "POST",
            url: '{{ route('like.total', $comment->getKey()) }}',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function (data) {
                if (data) {
                    button =
                        '<button id="list_like_{{ $comment->getKey() }}" type="button" onclick="getListLike({{ $comment->getKey() }})"><i class="mt-0.5 fa-regular fa-thumbs-up"></i> ' +
                        data + '</button>'
                }
                document.getElementById('sum_like_' + {{ $comment->getKey() }}).innerHTML = button;
            },
            error: function (error) {
                alert(error);
            }
        });
    }

    function getListLike($comment_id) {

        $.ajax({
            type: "GET",
            url: '/list-liker/' + $comment_id,
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function (data) {
                if (data != '') {
                    sizeData = data.length;
                    html = ''
                    for (let i = 0; i < sizeData; i++) {
                        html += '<div class="mt-2 inline-flex gap-2 w-full">\
                    <img class="image rounded-full lg:w-16 w-8 object-cover"\
                    src="{{ \App\Models\User::AVATA[array_rand(\App\Models\User::AVATA, 1)] }}"\
                    alt="{{ $comment->commenter->name ?? $comment->guest_name }} Avatar">\
                    <p class="mt-2">' + data[i].name + '</p>\
                            </div>';
                    }

                    document.getElementById('list_liker').innerHTML = html;

                    document.getElementById('form').classList.toggle("hidden");
                }
            },
            error: function (xhr, status, error) {
                alert(error);
            }
        });
    }

    function close() {
        $("#form").hide();
    }

</script>
