var Weborobot = {};

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  Утилиты 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Weborobot.Util = {};


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  Проверка строки на длину
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
Weborobot.Util.isLength = function(value, minLength, maxLength)
{
value = value == undefined ? "" : value;
minLength = minLength == undefined ? 0 : minLength;

	if(value.length == 0 && minLength == 0)
	{
	return true;
	}

var re = /.+/;

	if(value.match(re)) return !(value.length < minLength || value.length > maxLength);
	else return false;
};



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  Проверка строки что она состоит из латиници или чисел
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Weborobot.Util.isLatinica = function(value, minLength, maxLength, toLower)
{
toLower = toLower == undefined ? false : toLower;
var how = Weborobot.Util.isLength(value, minLength, maxLength);

	if(how == true)
	{
	var re;

		if(toLower == false) re = /^[a-zA-Z0-9_-]*$/;
		else re = /^[a-z0-9_-]*$/;

		return value.match(re);
	}
	else return false;
};

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  Проверка строки что она состоит из символов и пробелов
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Weborobot.Util.isAlpha = function(value, minLength, maxLength)
{
var how = Weborobot.Util.isLength(value, minLength, maxLength);

	if(how == true)
	{
	var re = /^[^0-9]*$/;

	return value.match(re);
	}
	else return false;
};


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  Проверка строки что это E-mail
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Weborobot.Util.isEmail = function(value, needs, many)
{
var how;

	if(needs == true)
	{
	how = Weborobot.Util.isLength(value, 1);
		
		if(!how) return false;
	}
	else
	{
	how = Weborobot.Util.isLength(value, 0, 0);
	
		if(how) return true;
	}

var re;
	
	if(many == true) re = /^([\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}(, ?)?)*$/;
	else re = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;

	return value.match(re) === null ? false : true;
};


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  Проверка строки что это ссылка на сайт
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Weborobot.Util.isUrl = function(value, needs)
{
var how;

	if(needs == true)
	{
	how = Weborobot.Util.isLength(value, 1);
		
		if(!how) return false;
	}
	else
	{
	how = Weborobot.Util.isLength(value, 0, 0);
	
		if(how) return true;
	}
	
var re = /^((https?|ftp)\:\/\/){1}([a-zA-ZА-Яа-я0-9]{1})((\.[a-zA-ZА-Яа-я0-9-])|([a-zA-ZА-Яа-я0-9-]))*\.([a-zA-ZА-Яа-я]{2,6})(\/[-_\w\.]*)*(\/?)(\??)([-_\w]*=?[ -_\w]*&?)*(#[-_\w]*)?$/;

	return value.match(re) === null ? false : true;
};


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  Проверка строки что это IP
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Weborobot.Util.isIp = function(value, needs)
{
var how;

	if(needs == true)
	{
	how = Weborobot.Util.isLength(value, 1);
		
		if(!how) return false;
	}
	else
	{
	how = Weborobot.Util.isLength(value, 0, 0);
	
		if(how) return true;
	}
	
var re = /^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/;

	return value.match(re);
};




//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  Проверка строки что это время
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Weborobot.Util.isTime = function(value, needs)
{
var how;

	if(needs == true)
	{
	how = Weborobot.Util.isLength(value, 1);
		
		if(!how) return false;
	}
	else
	{
	how = Weborobot.Util.isLength(value, 0, 0);
	
		if(how) return true;
	}
	
var re = /^\d{1,2}(\:)\d{2}$/;
	
	if(!value.match(re)) return false;
	else
	{
	var time = value.split(":");
	time[0] = parseInt(time[0], 10);
	time[1] = parseInt(time[1], 10);

	return (time[0] >= 0 && time[0] <= 23 && time[1] >= 0 && time[1] <= 59);
	}
};



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  Проверка строки что это дата формата ДД.ММ.ГГГГ
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Weborobot.Util.isDate = function(value, needs)
{
var how;

	if(needs == true)
	{
	how = Weborobot.Util.isLength(value, 1);
		
		if(!how) return false;
	}
	else
	{
	how = Weborobot.Util.isLength(value, 0, 0);
	
		if(how == true) return true;
	}

var re = /^\d{1,2}(\.)\d{1,2}(\.)\d{4}$/;
	
	if(!value.match(re)) return false;
	else
	{
	var date = value.split(".");
	var testDate = new Date(date[2], date[1] - 1, date[0]);
	date[0] = parseInt(date[0], 10);
	date[1] = parseInt(date[1], 10);
	date[2] = parseInt(date[2], 10);
		
		if(testDate.getDate() == date[0])
		{
			if((testDate.getMonth() + 1) == date[1]) return (testDate.getFullYear() == date[2]);
			else return false;
		}
		else return false;
	}
};



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//   Проверка что это число
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Weborobot.Util.isInteger = function(value, unsigned, minLength, maxLength, minNumber, maxNumber)
{
var how, re;

	if(minLength != undefined || maxLength != undefined)
	{
	how = Weborobot.Util.isLength(value, minLength, maxLength);
	
		if(how == false) return false;
	}

	if(unsigned == true) re = /^\d*$/;
	else re = /^[-]?\d*$/;
	
value = value.toString();

	if(!value.match(re)) return false;
	else
	{
	how = Weborobot.Util.isCorrectIntegerDiapozone(value, minNumber, maxNumber);
	
		if(how == false) return false;
	}
	
return true;
};


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//   Проверка что это дробное число
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Weborobot.Util.isFloat = function(value, unsigned, minLength, maxLength, minNumber, maxNumber, delimetr)
{
var how, re;
delimetr = delimetr == undefined ? "." : delimetr;

	if(minLength != undefined || maxLength != undefined)
	{
	how = Weborobot.Util.isLength(value, minLength, maxLength);
	
		if(how == false) return false;
	}

	if(unsigned == true)
	{
		if(delimetr == ".") re = /^\d*\.?\d*$/;
		else if(delimetr == ",") re = /^\d*,?\d*$/;
	}
	else
	{
		if(delimetr == ".") re = /^[-]?\d*\.?\d*$/;
		else if(delimetr == ",") re = /^[-]?\d*,?\d*$/;
	}

value = value.toString();
	
	if(!value.match(re)) return false;
	else
	{
	how = Weborobot.Util.isCorrectIntegerDiapozone(value, minNumber, maxNumber);
	
		if(how == false) return false;
	}
	
return true;
};


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//   Проверить входит ли число в диапозон
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Weborobot.Util.isCorrectIntegerDiapozone = function(number, min, max)
{
var isCorrect = true;

	if(min != undefined && number < min) isCorrect = false;
	if(max != undefined && number > max) isCorrect = false;
	
return isCorrect;
};


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//   Округление числа
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Weborobot.Util.toFixed = function(num, p)
{
	if(!p) return Math.round(num);
	
return Math.round(num * (Math.pow(10,p))) / Math.pow(10, p);
};


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//   Проверить входит ли дата в диапозон
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Weborobot.Util.isCorrectDateDiapozone = function(dateStart, dateEnd)
{
var howDateStart = Weborobot.Util.isDate(dateStart, true);
var howDateEnd = Weborobot.Util.isDate(dateEnd, true);

	if(howDateStart == true && howDateEnd == true)
	{
	dateStart = dateStart.split(".");
	dateStart = new Date(dateStart[2], dateStart[1] - 1, dateStart[0]);
	
	dateEnd = dateEnd.split(".");
	dateEnd = new Date(dateEnd[2], dateEnd[1] - 1, dateEnd[0]);

    return (dateStart < dateEnd);
	}
	else return false;
};


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//   Переводит русские символы в латиницу
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Weborobot.Util.toLatin = function(string, separator)
{
separator = separator == undefined ? "-" : 	separator;

	var order =
	{
	"а": "a",
	"б": "b",
	"в": "v",
	"г": "g",
	"д": "d",
	"е": "e",
	"ё": "e",
	"ж": "zh",
	"з": "z",
	"и": "i",
	"й": "y",
	"к": "k",
	"л": "l",
	"м": "m",
	"н": "n",
	"о": "o",
	"п": "p",
	"р": "r",
	"с": "s",
	"т": "t",
	"у": "u",
	"ф": "f",
	"х": "h",
	"ц": "c",
	"ч": "ch",
	"ш": "sh",
	"щ": "sh",
	"ъ": "",
	"ы": "i",
	"ь": "",
	"э": "e",
	"ю": "u",
	"я": "ya",
	
	"А": "A",
	"Б": "B",
	"В": "V",
	"Г": "G",
	"Д": "D",
	"Е": "E",
	"Ё": "E",
	"Ж": "ZH",
	"З": "Z",
	"И": "I",
	"Й": "Y",
	"К": "K",
	"Л": "L",
	"М": "M",
	"Н": "N",
	"О": "O",
	"П": "P",
	"Р": "R",
	"С": "S",
	"Т": "T",
	"У": "U",
	"Ф": "F",
	"Х": "H",
	"Ц": "C",
	"Ч": "CH",
	"Ш": "SH",
	"Щ": "SH",
	"Ъ": "",
	"Ы": "I",
	"Ь": "",
	"Э": "E",
	"Ю": "U",
	"Я": "Ya",

	" ": separator
	};

string = Weborobot.Util.trim(string);	
var translit = "";
	
	for (var i = 0; i < string.length; i++)
	{
		if(separator == string.charAt(i)) translit += separator;
		else if(/[а-яёА-ЯЁ ]/.test(string.charAt(i))) translit += order[string.charAt(i)];
		else if(/[a-z0-9A-Z ]/.test(string.charAt(i))) translit += string.charAt(i);
	}
	
return translit;
};


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//   Тримирование строки: убирает лишние пробелы, табы и т.д.
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Weborobot.Util.trim = function(str, charlist)
{
charlist = !charlist ? ' \s\xA0' : charlist.replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, '\$1');
var re = new RegExp('^[' + charlist + ']+|[' + charlist + ']+$', 'g');
return str.replace(re, '');
};


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//   Переводит BR к \n
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Weborobot.Util.parserBr2Rn = function(value)
{
	if(!value) return value;
	
var searcher = [];
searcher[0] = "<br>";
searcher[1] = "<br />";
searcher[2] = "<br/>";

value += '';

	for(var i = 0; i < searcher.length; i++)
	{
	var re = new RegExp(searcher[i], "g");
	value = value.replace(re, "\n");
	}

return value;
};


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//   Переводит \n к BR
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Weborobot.Util.parserRn2Br = function(value)
{
var searcher = [];
searcher[0] = "\r\n";
searcher[1] = "\n\r";
searcher[2] = "\n";
searcher[3] = "\r";

value += '';

	for(var i = 0; i < searcher.length; i++)
	{
	re = new RegExp(searcher[i], "g");
	value = value.replace(re, "<br />");
	}

return value;
};


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  Формотирование под деньги
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Weborobot.Util.getMoney = function(num)
{
var decpoint = ".",
	decpointNew = ",",
	sep = " ";

num = num.toString();

var hasMin = num.indexOf("-") === 0;

	if(hasMin) num = num.substring(1, num.length);

var a = num.split(decpoint),
	x = a[0],
	y = a[1],
	z = "";

	if(y)
	{
	y = y.toString();

		if(y.length > 2) y = y.substring(0, 2);
		if(y == "00") y = "";
	}

	if(typeof(x) != "undefined")
	{
		for(i = x.length - 1; i >= 0; i--) z += x.charAt(i);

	z = z.replace(/(\d{3})/g, "$1" + sep);

		if(z.slice(-sep.length) == sep) z = z.slice(0, -sep.length);

	x = "";

		for (i = z.length - 1; i >= 0; i--) x += z.charAt(i);

		if(typeof(y) != "undefined" && y.length > 0) x += decpointNew + y;
	}

	if(hasMin == true) x = "-" + x;

return x;
};



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  Генерация пароля
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Weborobot.Util.generatePassword = function(length)
{
var ints = [0,1,2,3,4,5,6,7,8,9,0],
chars = ['a','b','c','d','e','f','g','h','j','k','l','m','n','o','p','r','s','t','u','v','w','x','y','z'],
out = '',
ch2;

	for(var i = 0; i < length; i++)
	{
	var ch = Math.random(1,2);
		
		if(ch < 0.5)
		{
		ch2 = Math.ceil(Math.random(1, ints.length) * 10);
		out += ints[ch2];
		}
		else
		{
		ch2 = Math.ceil(Math.random(1, chars.length) * 10);
		out += chars[ch2];          
		}
	}

return out;
};