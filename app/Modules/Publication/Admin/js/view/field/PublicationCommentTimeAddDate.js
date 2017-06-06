Ext.define('Publication.view.field.PublicationCommentTimeAddDate',
	{
    extend: 'Ext.form.field.Time',
	xtype: "Publication.view.field.PublicationCommentTimeAddDate",
	
	fieldLabel: "Время добавления:<span class='needsForm'>*</span>",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "timeAdd",
	reference: "timeAdd",
	
	format: "H:i:s",
	increment: 10,
	value: Ext.Date.format(new Date(), "H:i:s"),
	
	msgTarget: 'side',
	
		validator: function(value)
		{			
			if(typeof value == "object") return true;
			
			if(Weborobot.Util.isLength(value, 1) == false)
			return "Время должно быть определено!";
			else return true;
		}
	}
);
	