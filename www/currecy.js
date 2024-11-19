"use strict";

let account = document.getElementById('accountNumber');
let summaRub = document.getElementById('summaRub');
let summaOplata = document.getElementById('summaOplata');
let selectCurrency = document.getElementById('selectCurrency');
let nameCurrency = document.getElementById('nameCurrency');
let divDisplay = document.getElementById('divDisplay');
let btn = document.getElementById('btn');
let sendForm = document.getElementById('sendForm');

let kursBtc;
let kursUsdt;
let kursWMZ;
let kursWMT;
let kursWMX;

let minSummaBtc = 0.0001;
let minSummaUsdt = 0.5;
let minSummaWMZ = 1;
let minSummaWMT = 0.5;
let minSummaWMX = 0.01;
let minSummRub = 1.00;
let maxSumRub = 20000.00;
let stepRub = 0.01;
let accountPatern = "^[0-9]{5}$";

selectCurrency.addEventListener('change', function() {
	nameCurrency.textContent = this.value;
    summaOplata.value = '';
	summaRub.value = '';
    summaRub.min = minSummRub;
    summaRub.step = stepRub;
    summaRub.max = maxSumRub;
	summaRub.placeholder = ' ' + minSummRub + ' - ' + maxSumRub;
    selectCurrency.style.color = "green";
    summaOplata.style.color = "green";
    summaRub.style.color = "green";

		switch(this.value) {
        case 'BTC':
            summaOplata.placeholder = minSummaBtc;
            summaOplata.min = minSummaBtc;
            summaOplata.step = 0.0001;
            inputSumma(kursBtc,minSummaBtc,10000);
        break;
        case 'USDT':
            summaOplata.placeholder = minSummaUsdt;
            summaOplata.min = minSummaUsdt;
            summaOplata.step = 0.01;
            inputSumma(kursUsdt,minSummaUsdt,100);
        break;
        case 'WMZ':
            summaOplata.placeholder = minSummaWMZ;
            summaOplata.min = minSummaWMZ;
            summaOplata.step = 0.01;
            inputSumma(kursWMZ,minSummaWMZ,100);
        break;
        case 'WMX':
            summaOplata.placeholder = minSummaWMX;
            summaOplata.min = minSummaWMX;
            summaOplata.step = 0.01;
            inputSumma(kursWMX,minSummaWMX,100);
        break;
        case 'WMT':
            summaOplata.placeholder = minSummaWMT;
            summaOplata.min = minSummaWMT;
            summaOplata.step = 0.01;
            inputSumma(kursWMT,minSummaWMT,100);
        break;
		default:
            inputSumma(1,1);
            selectCurrency.style.color = "red";
		break;
        }
});

account.addEventListener('input', function() {
    validatingFields (account, accountPatern);
});

sendForm.addEventListener('submit', function(event) {
    if (!validatingFields (account, accountPatern)) {
        event.preventDefault();
        showError(account, 'Не верный номер счёта');
        return true;
    }
    ShowRow(btn, false);
    return true;
});

function inputSumma(kursCurrRub,minSummaCurr,round_off=0) {
    summaRub.addEventListener('input', function() {
		let summa = summaRub.value / kursCurrRub;
        if (summa >= minSummaCurr && minSummRub <= summaRub.value && round_off > 0) {
            summaOplata.value = Math.ceil(summa * round_off) / round_off;
        } else {
			summaOplata.value = '';
		}
        
    });
    summaOplata.addEventListener('input', function() {
        let summa = summaOplata.value * kursCurrRub;
        if (summa >= minSummRub && summa <= maxSumRub && minSummaCurr <= summaOplata.value && round_off > 0) {
            summaRub.value = Math.ceil(summa * 100) / 100;
        }  else {
			summaRub.value = '';
		} 
    });
}

function validatingFields (id, patern) {
    let rel = new RegExp(patern);
    if (id.value.match(rel) != id.value) {
	  id.style.color = "red";
       return false;
    } else { 
        id.style.color = "green";
        return true;
		}
}
function showError(element, msg) {
    alert(msg);
    element.focus();
    return false;
}

function ShowRow(id, show) { 
    if(id != null) { 
        if(show){
            id.style.display = '';
        }
        else {
            id.style.display = 'none';
        }
    } 
}

async function fetchData() {
    let response = await fetch('/kurs.php');
    if (response.ok) {
        let kursy = await response.json();
        kursBtc = Number(kursy['kursBtc']);
        kursUsdt = Number(kursy['kursUsdt']);
        kursWMZ = Number(kursy['kursWMZ']);
        kursWMT = Number(kursy['kursWMT']);
        kursWMX = Number(kursy['kursWMX']) * kursWMZ;
    } else {
        ShowRow(btn, false);
    }
}
fetchData();
