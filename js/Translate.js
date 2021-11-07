$(document).ready(function(){
    translatePage();
});


function translatePage() {
    language = getCookie("language-selected");

    var lang=language, // Check the Browser language
        translate; // Container of all translations

    // Call translations json file and populate translate variable
    $.getJSON("../Locates/translations.json", function(texts) {
        translate=texts;
        // Translate all the element with data-translate
        translateElement("data-translate", translate, lang);
    });


    function translateElement(elementName, translate, lang) {
        $("[" + elementName + "]").each(function() {
            let text= $(this).attr(elementName), // Save the Text into the variable
                numbers= text.match(/\d+/g),
                dinamicText = text.match(/%(.*?)%/g),
                element=  $('[' + elementName + '="'+text+'"]'),
                postHTML;

            if (dinamicText != null) {
                dinamicText.forEach(function(tag) { text = text.replace(tag, '%c'); });
            }

            if (numbers != null && numbers>1)
                text= text.replace(numbers, '%n');

            if (translate[text]!==undefined) { // Check if exist the text in translation.json

                if (translate[text][lang]!==undefined) { // Check if exist the text in the language
                    postHTML= translate[text][lang];
                } else { // If not exist the lang, show the text in primary
                    postHTML= text;
                }

                if (numbers != null && numbers>1)
                    postHTML= postHTML.replace('%n', numbers);

                if (dinamicText != null) {
                    dinamicText.forEach(function(tag) {
                        tag = tag.replace("%", "<b>");
                        tag = tag.replace("%", "</b>")
                        postHTML = postHTML.replace('%c', tag);
                    });
                }

                // Set placeholders
                if (($(this)[0].tagName === "INPUT")) {
                    $('[' + elementName + '="'+text+'"]').attr("placeholder", postHTML);
                } else {
                    element.html(postHTML);
                }

            } else {
                $('[' + elementName + '="'+text+'"]').html("ERR").css({'color':'red','font-weight':'bold'});
            }
        });
    }
}