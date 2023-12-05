
fetch("https://api.currencyapi.com/latest?apikey=cur_live_JE7nMjwSbn0GQwHeab1OrCY9SYDvZu0FzxSzRRYB")
  .then((result) => {
    // console.log(result);
    let myData = result.json();
    // console.log(myData);
    return myData;
  }).then((currency) => {

    let amount = document.querySelector(".amount");
    let eurPrice = document.querySelector(".eur span");
    let usdPrice = document.querySelector(".usd span");

    eurPrice.innerHTML = Math.round(amount.innerHTML * currency.rates["EUR"]);
    usdPrice.innerHTML = Math.round(amount.innerHTML * currency.rates["USD"]);

    console.log(currency.rates);
    console.log(currency.rates["EUR"]);
    console.log(currency.rates["USD"]);
});
  