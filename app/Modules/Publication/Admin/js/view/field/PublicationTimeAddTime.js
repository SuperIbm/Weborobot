Ext.define('Publication.view.field.PublicationTimeAddTime', 
	{
    extend: 'Ext.form.field.Time',
	xtype: "Publication.view.field.PublicationTimeAddTime",
	
	fieldLabel: "Время добавления:<span class='needsForm'>*</span>",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "timeAdd",
	reference: "timeAdd",
	
	format: "H:i",
	increment: 10,
	snapToIncrement: true,
	value: Ext.Date.format(new Date(), "H:i"),
	
	msgTarget: 'side',
	
		validator: function(value)
		{			
			if(typeof value == "object") return true;
			
			if(Weborobot.Util.isLength(value, 1) == false)
			return "Время публикации должно быть определено!";
			else return true;
		}
	}
);
	