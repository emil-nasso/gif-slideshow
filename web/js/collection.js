function initAllCollections(){
    $("div[data-prototype][data-initialized!=1]").each(function(index, element){
       initCollection($(element));
    });
}


function initCollection($collectionHolder) {
    var $addButton = $('<button type="button" class="btn btn-primary btn-xs add-col-entry"><span class="glyphicon glyphicon-plus"></span></button>'),
        $addButtonRow = $('<div class="form-group add-col-row"></div>');

    $collectionHolder.data('index', $collectionHolder.children('div').length);

    $addButton.click(function (e) {
        e.preventDefault();

        addCollectionEntry($collectionHolder);
        initAllCollections();
        return false;
    });

    initCollectionRow($collectionHolder.find('> .form-group'));

    $addButtonRow.append($addButton);
    $collectionHolder.append($addButtonRow);
    $collectionHolder.attr('data-initialized','1');
}

function initCollectionRow($element) {
    var $removeButton = $('<button type="button" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-minus"></span></button>');

    $removeButton.click(function (e) {
        e.preventDefault();

        $(e.target).closest('.col-row').remove();

        initAllCollections();
        return false;
    });

    $element.addClass('col-row');
    $element.append($removeButton);
}

function addCollectionEntry($collectionHolder) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // Get the new index
    var index = $collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var $newLine = $($.trim(prototype.replace(/__name__/g, index)));

    initCollectionRow($newLine);

    // Increase the index by one for the next item
    $collectionHolder.data('index', index + 1);
    $collectionHolder.find('.add-col-row').before($newLine);
}
