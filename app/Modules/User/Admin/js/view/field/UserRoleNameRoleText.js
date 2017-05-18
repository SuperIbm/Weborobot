Ext.define('User.view.field.UserRoleNameRoleText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "User.view.field.UserRoleNameRoleText",
	
	fieldLabel: "Название роли:<span class='needsForm'>*</span>",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "nameRole",
	reference: "nameRole",
	
	msgTarget: 'side',
	
		validator: function(value)
		{						
			if(Weborobot.Util.isLength(value, 1, 100) == false)
			return "Название роли должно содержать от 1 до 100 символов!";
			else return true;
		}
	}
);
	