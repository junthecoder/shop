const formatter = new Intl.NumberFormat('ja-JP', {
  style: 'currency',
  currency: 'JPY',
});

$('.price').each((_, x) => {
  console.log('here');
  $(x).text(formatter.format($(x).text()));
});
