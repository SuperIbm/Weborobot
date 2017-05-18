Ext.define('User.view.field.UserGroupNameGroupText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "User.view.field.UserGroupNameGroupText",
	
	fieldLabel: "Название группы:<span class='needsForm'>*</span>",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "nameGroup",
	reference: "nameGroup",
	
	msgTarget: 'side',
	
		validator: function(value)
		{						
			if(Weborobot.Util.isLength(value, 1, 100) == false)
			return "Название группы должно содержать от 1 до 100 символов!";
			else return true;
		}
	}
);
	