$('.language-mermaid').each(function ($obj) {
    $(this).parent().after('<div class="mermaid">' + $(this).html() + '</div>');
});
mermaid.initialize({startOnLoad: true, theme: 'forest'});