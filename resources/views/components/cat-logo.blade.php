{{-- CatFriends Club Logo Component --}}
<div class="flex items-center">
    {{-- Cat silhouette SVG logo --}}
    <svg {{ $attributes->merge(['class' => 'w-8 h-8 text-orange-500 dark:text-orange-400']) }} 
         viewBox="0 0 100 100" 
         fill="currentColor" 
         xmlns="http://www.w3.org/2000/svg">
        <g>
            {{-- Cat head silhouette --}}
            <path d="M50 15 
                     C42 15, 35 20, 35 28
                     L35 30
                     C32 28, 28 30, 28 35
                     C28 38, 30 40, 32 41
                     L32 45
                     C32 55, 40 62, 50 62
                     C60 62, 68 55, 68 45
                     L68 41
                     C70 40, 72 38, 72 35
                     C72 30, 68 28, 65 30
                     L65 28
                     C65 20, 58 15, 50 15 Z" />
            
            {{-- Left ear --}}
            <path d="M35 28 
                     L30 18
                     L40 22
                     Z" />
            
            {{-- Right ear --}}
            <path d="M65 28 
                     L70 18
                     L60 22
                     Z" />
            
            {{-- Inner ears --}}
            <path d="M33 25 
                     L31 20
                     L37 23
                     Z" 
                  fill="currentColor" 
                  opacity="0.3" />
            
            <path d="M67 25 
                     L69 20
                     L63 23
                     Z" 
                  fill="currentColor" 
                  opacity="0.3" />
            
            {{-- Eyes --}}
            <circle cx="42" cy="38" r="3" fill="white" />
            <circle cx="58" cy="38" r="3" fill="white" />
            <circle cx="43" cy="37" r="1.5" fill="currentColor" />
            <circle cx="59" cy="37" r="1.5" fill="currentColor" />
            
            {{-- Nose --}}
            <path d="M50 45 
                     L47 48
                     L53 48
                     Z" 
                  fill="white" 
                  opacity="0.8" />
            
            {{-- Mouth --}}
            <path d="M50 48 
                     C47 50, 45 52, 45 52
                     M50 48 
                     C53 50, 55 52, 55 52" 
                  stroke="white" 
                  stroke-width="1.5" 
                  fill="none" 
                  opacity="0.8" />
            
            {{-- Whiskers --}}
            <g stroke="currentColor" stroke-width="1" fill="none" opacity="0.6">
                {{-- Left whiskers --}}
                <line x1="25" y1="42" x2="35" y2="40" />
                <line x1="25" y1="45" x2="35" y2="45" />
                <line x1="25" y1="48" x2="35" y2="50" />
                
                {{-- Right whiskers --}}
                <line x1="75" y1="42" x2="65" y2="40" />
                <line x1="75" y1="45" x2="65" y2="45" />
                <line x1="75" y1="48" x2="65" y2="50" />
            </g>
            
            {{-- Body silhouette --}}
            <ellipse cx="50" cy="75" rx="20" ry="12" opacity="0.7" />
            
            {{-- Tail curl --}}
            <path d="M70 75 
                     C75 70, 80 65, 78 60
                     C76 55, 70 58, 68 62
                     C66 66, 68 70, 70 75" 
                  fill="currentColor" 
                  opacity="0.6" />
        </g>
    </svg>
    
    {{-- Brand text --}}
    @if($slot->isNotEmpty())
        <div class="ml-3">
            {{ $slot }}
        </div>
    @endif
</div>