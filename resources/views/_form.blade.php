<div class="card">
    <div class="card-body">
        @if ($errors->has('commentable_type'))
            <div class="alert alert-danger" role="alert">
                {{ $errors->first('commentable_type') }}
            </div>
        @endif
        @if ($errors->has('commentable_id'))
            <div class="alert alert-danger" role="alert">
                {{ $errors->first('commentable_id') }}
            </div>
        @endif
        <form method="POST" action="{{ route('comments.store') }}">
            @csrf
            @honeypot
            <input type="hidden" name="commentable_type" value="\{{ get_class($model) }}" />
            <input type="hidden" name="commentable_id" value="{{ $model->getKey() }}" />

            {{-- Guest commenting --}}
            @if (isset($guest_commenting) and $guest_commenting == true)
                <div class="form-group">
                    <label for="message">@lang('comments::comments.enter_your_name_here')</label>
                    <input type="text" class="form-control @if ($errors->has('guest_name')) is-invalid @endif"
                        name="guest_name" />
                    @error('guest_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="message">@lang('comments::comments.enter_your_email_here')</label>
                    <input type="email" class="form-control @if ($errors->has('guest_email')) is-invalid @endif"
                        name="guest_email" />
                    @error('guest_email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            @endif

            <div class="form-group">
                <textarea class="w-full px-4 py-2 border rounded-2xl bg-gray bg-[#F3F3F3] @if ($errors->has('message')) is-invalid @endif" name="message" rows="3" placeholder="@lang('comments::comments.enter_your_message_here')"></textarea>
            </div>
            <button type="submit" class="border bg-[#ff0000] text-[#ffffff] w-20 py-1 my-3 text-center rounded-xl">@lang('comments::comments.submit')</button>
        </form>
    </div>
</div>
<br />
