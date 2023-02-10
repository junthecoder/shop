'use strict';

const sortType = new URLSearchParams(window.location.search).get('sort') ;
if (sortType) {
  $('#sort-select').val(sortType);
}

$('#sort-select').on('change', function () {
    const sortType = $(this).val();
    if (sortType) {
        window.location = `/?sort=${sortType}`
    }
    return false;
});
