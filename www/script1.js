"use strict";

let ul = document.querySelector('#ul');
let tables = document.querySelectorAll('#table tr');
let table = document.getElementById('table');
let start = document.getElementById('start');
let stop = document.getElementById('stop');
let pars = document.querySelectorAll('#parent p');
let nomer = document.getElementById('nomer');
let par = document.querySelector('#par');
let show = document.querySelector('#show');
let hide = document.querySelector('#hide');
let tim = document.querySelector('#tim');
let number = document.getElementById('number');
let inp1 = document.getElementById('inp1');

let div = document.getElementById('div');
let di = document.querySelector('.di');
let timerID;
let arr = ['li1', 'li2', 'li3', 'li4', 'li5'];

function addZero(num) {
	if (num >= 0 && num <= 9) {
		return '0' + num;
	} else {
		return num;
	}
}

function funcPlus() {
	timerID = setInterval(function(){
		par.textContent++;
	},1000);
}
function funcMinus() {
	par.textContent = inp.value;
	timerID = setInterval(function(){	
		par.textContent--;
		if (par.textContent == 0) clearInterval(timerID);
	},2000);
}

function generTable() {
	
	let rows = inp1.value;
	let cols = inp.value;
	createTable(rows,cols,div);
}
//Игра угадай ячейку	
createTable(10,10,table);

function createTable(rows,cols,selector) {
	let k = 1;
	let l = 0;
	let cells = 10; // количество ячеек
	tim.textContent = 5;
	let table = document.createElement('table');
	table.id = 'game';
	let gener = cellGeneration(cells);
	console.log(gener);
		for (let i = 0; i < rows; i++) {
	       let tr = document.createElement('tr');
	       for (let j=0; j < cols; j++) {
		      let td = document.createElement('td');
		       td.textContent = k;
			   td.id = k;	   
			   for (let cell of gener) {
	              if (td.id == cell) {
		           td.addEventListener('click', function func() {
		             if (l < cells) {
			          l++;
					  nomer.textContent = 'Осталось ' + (Number(cells) - Number(l));
					  if (l == cells) nomer.textContent = 'Ты победил!';
					  td.removeEventListener('click', func);
		             } else {
			           td.removeEventListener('click', func);
		               }
	                });	
	             }
               }
			   
		       tr.appendChild(td);
			   k++;
	        }
	       table.appendChild(tr);
       }
	   selector.insertAdjacentElement('afterEnd',table);
	  let game = document.getElementById('game'); 	   
	   timerID = setInterval(function(){	
		tim.textContent--;
		if (tim.textContent == 0) {
			game.classList.add('hidden'); 
			clearInterval(timerID);
		}
	},60000);
}

function cellGeneration(cell) {
	let arr = [];
	for (let i=0; i<cell; i++) {
        let rand = getRandomInt(1, 100);
        if (arr.includes(rand) == false) {		
		    arr.push(rand);
	    } else {i--;}
   }
   return arr;
}


function getRandomInt(min, max) {
	return Math.floor(Math.random() * (max - min + 1)) + min;
}
stop.addEventListener('click', function() {
	let clone = inp.cloneNode();
	start.insertAdjacentElement('afterEnd',clone);
});

start.addEventListener('click', generTable);

function addInput(elem) {
    elem.addEventListener('click', function func() {
	let input = document.createElement('input');
	input.value = elem.textContent;
	
	elem.textContent = '';
	elem.appendChild(input);
	
	input.addEventListener('blur', function() {
		elem.textContent = this.value;
		elem.addEventListener('click', func); // повесим событие обратно
	});
	input.focus();
	elem.removeEventListener('click', func);
});
}



for (let p of pars) {
	let span = document.createElement('span');
	span.textContent = p.textContent;
	p.textContent = '';
	p.appendChild(span);
	let remov = document.createElement('a');
	remov.textContent = ' зачеркнуть';
	remov.href = "/";
	remov.addEventListener('click', function(event) {
		span.classList.add('through');
		remov.remove();
		event.preventDefault();
	});
	p.append(remov);
}
//addInput('#parent p span');

for (let tr of tables) {
	let td = document.createElement('td');
	let a = document.createElement('a');
	a.href = '/';
	a.textContent = 'green'
	a.addEventListener('click', function(event) {
		tr.classList.toggle('backgreen');
		event.preventDefault();
	});
	td.appendChild(a);
	tr.appendChild(td);
}

show.addEventListener('click', function(event) {
	show.value = 'Показать';
	par.classList.toggle('hidden');
});


for (let ar of arr) {
	let li = document.createElement('li');
	let remov = document.createElement('a');
	
	let span = document.createElement('span');
	let through = document.createElement('a');
	
	span.textContent = ar;
	addInput(span);
	
	remov.textContent = ' удалить ';
	remov.href = '/remov';
	remov.addEventListener('click', function() {
		li.remove();
		event.preventDefault();
	});
	
	through.textContent = ' зачеркнуть ';
	through.href = 'through';
	through.addEventListener('click', function(event) {
		span.classList.toggle('through');
		event.preventDefault();
	});
	
	ul.appendChild(li);
	li.appendChild(span);
	li.appendChild(remov);
	li.appendChild(through);
}
let input = document.createElement('button');
input.textContent = 'Добавить';
input.addEventListener('click', function() {
	let li = document.createElement('li');
	li.textContent = ' x ';
	addInput(li);
	ul.appendChild(li);
});
ul.insertAdjacentElement('afterEnd',input);

//Игра угадай число
let rand_num = getRandomInt(1, 100);

number.addEventListener('input', function() {
	if (isNaN(number.value)) {
		par.textContent = false;
	} else if (number.value < rand_num) {
		par.textContent = 'введите число побольше';
	} else if (number.value > rand_num) {
		par.textContent = 'введите число поменьше';
	} else { par.innerHTML = '<i>угадал!!!!</i>'; }
});
