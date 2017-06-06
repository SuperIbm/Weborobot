Ext.define('Publication.view.field.PublicationCommentDateAddDate',
	{
    extend: 'Ext.form.field.Date',
	xtype: "Publication.view.field.PublicationCommentDateAddDate",
	
	fieldLabel: "Дата добавления:<span class='needsForm'>*</span>",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "dateAdd",
	reference: "dateAdd",
	
	format: "d.m.Y",
	value: Ext.Date.format(new Date(), "d.m.Y"),
	
	msgTarget: 'side',
	
		validator: function(value)
		{			
			if(Weborobot.Util.isDate(value, true) == false)
			return "Проверьте корректность введенной даты!";
			else return true;
		}
	}
);
	