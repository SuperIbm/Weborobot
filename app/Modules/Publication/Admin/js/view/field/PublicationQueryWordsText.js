Ext.define('Publication.view.field.PublicationQueryWordsText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "Publication.view.field.PublicationQueryWordsText",
	
	fieldLabel: "Ключевые слова:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "queryWords",
	reference: "queryWords",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 0, 255) == false)
			return "Слишком много ключевых слов!";
			else return true;
		}
	}
);
	