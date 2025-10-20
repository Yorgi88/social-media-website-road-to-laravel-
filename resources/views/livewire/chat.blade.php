<div x-data="{ isOpen: false}">
    {{-- Stop trying to control. --}}
    <span x-on:click="isOpen = true; document.querySelector('.chat-field').focus()" class="text-white mr-2 header-chat-icon" title="Chat" data-toggle="tooltip" data-placement="bottom"><i class="fas fa-comment"></i></span>
    
    <div id="chat-wrapper" x-bind:class="isOpen ? 'chat--visible' : '' " class="chat-wrapper chat-wrapper--ready shadow border-top border-left border-right" data-username="{{auth()->user()->name}}" data-avatar="{{auth()->user()->avatar}}">
        <div class="chat-title-bar">Chat <span x-on:click="isOpen = false" class="chat-title-bar-close"><i class="fas fa-times-circle"></i></span></div>
            <div id="chat" class="chat-log"></div>
    
        <form id="chatForm" class="chat-form border-top">
            <input type="text" class="chat-field" id="chatField" placeholder="Type a message…" autocomplete="off">
        </form>
        </div>
</div>
