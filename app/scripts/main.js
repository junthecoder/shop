const formatter = new Intl.NumberFormat('ja-JP', {
  style: 'currency',
  currency: 'JPY',
});

$('.price').each((_, x) => {
  $(x).text(formatter.format($(x).text()));
});
