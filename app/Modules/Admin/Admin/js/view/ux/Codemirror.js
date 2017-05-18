// Подгрузим CSS библиотеки
$('HEAD')
.append('<link type="text/css" rel="stylesheet" href="node_modules/codemirror/lib/codemirror.css" />')
.append('<link type="text/css" rel="stylesheet" href="node_modules/codemirror/addon/hint/show-hint.css" />');

// Подгрузим саму библиотеку
var libers = 
[
"node_modules/codemirror/lib/codemirror.js",

"node_modules/codemirror/mode/javascript/javascript.js",
"node_modules/codemirror/mode/xml/xml.js",
"node_modules/codemirror/mode/htmlmixed/htmlmixed.js",
"node_modules/codemirror/mode/php/php.js",
"node_modules/codemirror/mode/sql/sql.js",
"node_modules/codemirror/mode/css/css.js",
"node_modules/codemirror/mode/smarty/smarty.js",
"node_modules/codemirror/mode/clike/clike.js",

"node_modules/codemirror/addon/fold/foldcode.js",
"node_modules/codemirror/addon/fold/xml-fold.js",
"node_modules/codemirror/addon/edit/matchbrackets.js",
"node_modules/codemirror/addon/edit/closebrackets.js",
"node_modules/codemirror/addon/edit/closetag.js",

"node_modules/codemirror/addon/hint/show-hint.js",
"node_modules/codemirror/addon/hint/xml-hint.js",
"node_modules/codemirror/addon/hint/html-hint.js",
"node_modules/codemirror/addon/hint/javascript-hint.js"
];

for(var i = 0; i < libers.length; i++)
{
	Ext.Loader.loadScript
	(
		{
		url: libers[i]	
		}
	);
}


// Определим сам класс
Ext.define("Admin.view.ux.Codemirror",
	{
	extend: 'Ext.form.field.TextArea',
	xtype: 'codemirror',
	alias: 'widget.codemirror',
	
	value: "",
	
		onRender: function()
		{		
		this.callParent();
		var thisObj = this, value;
		
			if(this.getValue()) value = this.getValue();
			else if(this.getInitialConfig('value')) value = this.getInitialConfig('value');
			else value = "";
			
		this.getEl().dom.value = value;
		var optionsDefault = this.getInitialConfig();

			if(!optionsDefault["keyMap"]) optionsDefault["keyMap"] = 'default';
		
			this.CodeMirror = CodeMirror.fromTextArea(this.getEl().dom,
				Ext.apply
				(
					{
					mode: "htmlmixed",
					lineNumbers: true,
					smartIndent: false,
					keyMap: 'default',
					
					autoCloseBrackets: true,
					autoCloseTags: true,
						extraKeys:
						{
						"Ctrl": "autocomplete"
						}
					},
                optionsDefault
				)
			);
		
		this.CodeMirror.setSize(this.width, this.height);
		},
		setValue:function(value)
		{
		value = value == null ? "" : value;
		
			if(this.CodeMirror)	return this.CodeMirror.setValue(value);
			else return "";
		},
		getValue:function()
		{
			if(this.CodeMirror)	return this.CodeMirror.getValue();
			else return "";
		},
		getRawValue:function()
		{
			if(this.CodeMirror)	return this.CodeMirror.getValue();
			else return "";
		}
	}
);