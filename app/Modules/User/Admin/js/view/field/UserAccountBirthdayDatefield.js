Ext.define('User.view.field.UserAccountBirthdayDatefield', 
	{
    extend: 'Ext.form.field.Date',
	xtype: "User.view.field.UserAccountBirthdayDatefield",
	
	fieldLabel: "День рождения:",
	
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "birthday",
	reference: "birthday",
	
	msgTarget: 'side',
	
	format: "d.m.Y",
	
		validator: function(value)
		{				
			if(Weborobot.Util.isDate(value, false) == false)
			return "Проверьте корректность введенной даты!";
			else return true;
		}
	}
);
	