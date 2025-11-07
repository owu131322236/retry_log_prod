window.initReactionsEvents = function(){
    document.querySelectorAll('.reactions-button').forEach(button => {
        const reactionMenu = button.querySelector('.reactions-menu');
        const wrapper = document.querySelector('.reactions-wrapper');
        button.addEventListener('click', e => {
            e.stopPropagation();
            reactionMenu.classList.toggle('hidden');
        });

        wrapper.addEventListener('mouseleave', () => {
            reactionMenu.classList.add('hidden');
        });
    });
};
document.addEventListener('DOMContentLoaded', window.initReactionsEvents);