Ext.define('User.view.field.UserBlockIpIpText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "User.view.field.UserBlockIpIpText",
	
	fieldLabel: "IP:<span class='needsForm'>*</span>",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "ip",
	reference: "ip",
	
	msgTarget: 'side',
	
		validator: function(value)
		{
		var re = /^(([0-9]{1,3})|(\*{1}))\.(([0-9]{1,3})|(\*{1}))\.(([0-9]{1,3})|(\*{1}))\.(([0-9]{1,3})|(\*{1}))$/;
		
			if(!value.match(re))
			{
			return "Вами введен некорректный IP адрес или паттерн для проверки!";
			}
			else
			{
			return true;
			}
		}
	}
);
	