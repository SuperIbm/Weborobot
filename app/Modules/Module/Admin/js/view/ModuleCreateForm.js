Ext.define('Module.view.ModuleCreateForm',
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.Module.view.ModuleCreateForm',
	
	padding: 15,
	
	bodyBorder: false,
	border: false,
	frame: false,
	
		items:
		[
			{
			xtype: "comboBoxStatus"
			},
			{
			xtype: "textfield",
			fieldLabel: "Папка модуля:<span class='needsForm'>*</span>",
			
			labelSeparator: "",
			labelWidth: 160,
			width: 450,
			
			name: "nameDir",
			reference: "nameDir",
			
			msgTarget: 'side',
			
				validator: function(value)
				{					
					if(Weborobot.Util.isLatinica(value, 1, 100, false) == false)
					return "Папка модуля должна содержать только латиницу или цифры, написанные в нижнем регистре!";
					else return true;
				}
			},
			{
			xtype: "filefield",
			fieldLabel: "Архив с модулем:<span class='needsForm'>*</span>",
			
			labelSeparator: "",
			labelWidth: 160,
			width: 450,
			
			name: "file",
			reference: "file",
			
			msgTarget: 'side',
			
				validator: function(value)
				{
					if(Weborobot.Util.isLength(value, 1) == false)
					return "Путь к архиву модулем должен быть определен! Допустимые форматы: *.zip";
					else return true;
				}	
			}
		]
	}
);