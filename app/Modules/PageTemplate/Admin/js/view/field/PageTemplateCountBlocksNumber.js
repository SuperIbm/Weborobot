Ext.define('PageTemplate.view.field.PageTemplateCountBlocksNumber', 
	{
    extend: 'Ext.form.field.Number',
	xtype: "PageTemplate.view.field.PageTemplateCountBlocksNumber",
	
	fieldLabel: "Количество блоков:<span class='needsForm'>*</span>",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "countBlocks",
	reference: "countBlocks",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isInteger(value, true, 1, 3) == false)
			return "Количество блоков должно содержать положительное целое число!";
			else return true;
		}
	}
);
	