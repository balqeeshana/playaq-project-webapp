@extends('layouts.app')

@section('title', 'Chat with ' . $receiver->name . ' - PLAYAQ')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-xl overflow-hidden flex flex-col h-[600px]">
        <!-- Chat Header -->
        <div class="bg-gradient-to-r from-brand-600 to-indigo-600 p-4 text-white flex justify-between items-center shadow-md">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center font-bold text-lg text-white">
                    {{ substr($receiver->name, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-white font-bold leading-tight">{{ $receiver->name }}</h2>
                    <p class="text-indigo-200 text-xs capitalize">{{ $receiver->role }}</p>
                </div>
            </div>
            
            <a href="{{ Auth::user()->isProfessional() ? '/pro/dashboard' : '/dashboard' }}" class="text-white hover:text-indigo-200 transition-colors">
                <i data-lucide="x" class="w-6 h-6"></i>
            </a>
        </div>

        <!-- Chat Messages Thread -->
        <div class="flex-grow overflow-y-auto p-6 space-y-4 bg-slate-50" id="messages-container">
            @if($messages->isEmpty())
                <div class="text-center py-12 text-slate-400">
                    <i data-lucide="message-square" class="w-12 h-12 mx-auto mb-2 opacity-50"></i>
                    <p class="text-sm font-semibold">No messages yet</p>
                    <p class="text-xs">Type below to start your conversation with {{ $receiver->name }}.</p>
                </div>
            @else
                @foreach($messages as $msg)
                    <div class="flex {{ $msg->sender_id === Auth::id() ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[75%] rounded-2xl px-4 py-3 text-sm shadow-sm {{ $msg->sender_id === Auth::id() ? 'bg-brand-600 text-white rounded-br-none' : 'bg-white text-slate-800 rounded-bl-none border border-slate-150' }}">
                            <p class="leading-relaxed">{{ $msg->text }}</p>
                            <span class="block text-[10px] text-right mt-1.5 opacity-60">
                                {{ $msg->created_at->format('h:i A') }}
                            </span>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Message Input Form -->
        <div class="p-4 bg-white border-t border-slate-100">
            <form action="/chat/send" method="POST" class="flex items-center space-x-2">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
                <input type="text" name="text" required placeholder="Type a message to {{ $receiver->name }}..." autocomplete="off"
                       class="flex-grow border border-slate-200 focus:border-brand-500 rounded-xl px-4 py-3 text-sm outline-none transition-colors">
                <button type="submit" class="p-3 bg-brand-600 hover:bg-brand-700 text-white rounded-xl transition-colors shadow-md shadow-brand-500/10">
                    <i data-lucide="send" class="w-5 h-5"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Scroll chat thread to bottom on load
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('messages-container');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    });
</script>
@endsection
