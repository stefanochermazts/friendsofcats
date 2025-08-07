{{-- Single Comment --}}
<div class="p-4 border-b border-gray-100 dark:border-gray-700 last:border-b-0">
    <div class="flex space-x-3">
        {{-- User Avatar --}}
        <div class="flex-shrink-0">
            <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center">
                <span class="text-white font-semibold text-xs">
                    {{ substr($comment->user->name, 0, 1) }}
                </span>
            </div>
        </div>
        
        {{-- Comment Content --}}
        <div class="flex-1 min-w-0">
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                <div class="flex items-center space-x-2 mb-1">
                    <h5 class="text-sm font-semibold text-gray-900 dark:text-white">
                        {{ $comment->user->name }}
                    </h5>
                    <span class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $comment->created_at->diffForHumans() }}
                    </span>
                </div>
                <p class="text-sm text-gray-700 dark:text-gray-300">
                    {!! nl2br(e($comment->content)) !!}
                </p>
            </div>
        </div>
    </div>
</div>
