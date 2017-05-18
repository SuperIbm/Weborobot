Ext.define('User.view.field.UserAccountPassportWhenMadeDatefield', 
	{
    extend: 'Ext.form.field.Date',
	xtype: "User.view.field.UserAccountPassportWhenMadeDatefield",
	
	fieldLabel: "Когда выдан:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "passportWhenMade",
	ref: "passportWhenMade",
	
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
	