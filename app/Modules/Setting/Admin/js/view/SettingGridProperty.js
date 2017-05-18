Ext.define('Setting.view.SettingGridProperty', 
	{
    extend: 'Ext.grid.property.Grid',
	alias: 'widget.Setting.view.SettingGridProperty',
	
	name: "Setting",
	loadMask: true,
	columnWidth: .5,
	height: 200,
	nameColumnWidth: 290,
	
	bodyBorder: false,
	border: true,
	frame: false,
	
		source: 
		{
			
		},	
		initComponent: function()
		{
		var thisObj = this;
		
			function saveValue(label, newValue, callback)
			{
				Ext.Ajax.request
				(
					{
					url: '_api/Setting/SettingAdminController/update/',
					method: "POST",
						params:
						{
						label: label,
						value: newValue
						},
						success: function(response, options)
						{
						var jsonObj = Ext.util.JSON.decode(response.responseText);
							
							if(jsonObj["success"] == false)
							{
							thisObj.Grid.getStore().reload();	
								
								Ext.Msg.show
								(
									{
									title: "Ошибка!",
									msg: "Произошла ошибка выполнения программы на сервере!",
									icon: Ext.MessageBox.ERROR,
									buttons: Ext.MessageBox.OK
									}
								);
							}
							else
							{
								if(callback) callback.call(thisObj);	
							}
						},
						failure: function(response, options)
						{
						thisObj.Grid.getStore().reload();
							
							Ext.Msg.show
							(
								{
								title: "Ошибка!",
								msg: "Произошла ошибка выполнения программы на сервере!",
								icon: Ext.MessageBox.ERROR,
								buttons: Ext.MessageBox.OK
								}
							);
						}
					}
				);
			}
		
			this.sourceConfig = 
			{
				"Название сайта":
				{
					editor: Ext.create('Ext.form.field.Text', 
						{
						msgTarget: 'side',
							validator: function(value)
							{				
								if(Weborobot.Util.isLength(value, 1, 255) == false)
								return "Название сайта должно содержать от 1 до 255 символов!";
								else return true;
							},
							listeners:
							{
								blur: function(Trigger, evt, eops)
								{
								saveValue("APP_NAME", Trigger.getValue());
								}
							}
						}
					)
				},
				"E-mail администратора":
				{
					editor: Ext.create('Ext.form.field.Text', 
						{
						msgTarget: 'side',
							validator: function(value)
							{				
								if(Weborobot.Util.isEmail(value, false, true) == false)
								return "Проверьте корректность введенной электронной почты!";
								else return true;
							},
							listeners:
							{
								blur: function(Trigger, evt, eops)
								{
								saveValue("MAIL_TO_ADDRESS", Trigger.getValue());
								}
							}
						}
					)
				},
				"E-mail отправителя":
				{
					editor: Ext.create('Ext.form.field.Text', 
						{
						msgTarget: 'side',
							validator: function(value)
							{				
								if(Weborobot.Util.isEmail(value, false) == false)
								return "Проверьте корректность введенной электронной почты!";
								else return true;
							},
							listeners:
							{
								blur: function(Trigger, evt, eops)
								{
								saveValue("MAIL_FROM_ADDRESS", Trigger.getValue());
								}
							}
						}
					)
				},
				"Сайт на реконструкции":
				{
					editor: Ext.create('Ext.form.field.ComboBox',
						{					
							store: new Ext.data.ArrayStore
							(
								{
									fields:
									[
									"name"
									],
									data:
									[
										[
										"Да"
										],
										[
										"Нет"
										]
									]
								}
							),
						displayField: "name",
						valueField: "name",
						emptyText: "[Выберите статус]",
						name: "siteRekonstruction",
							validator: function(value)
							{
								if(Weborobot.Util.isLength(value, 1) == false)
								return "Вы должны определить статус!";
								else return true;
							},
							listeners:
							{
								change: function(Trigger, newValue, oldValue)
								{
								saveValue("APP_SITE_RECONSTRUCTION", Trigger.getValue() == "Да" ? 1 : 0);
								}
							}
						}
					)
				},
				"Путь к основному CSS":
				{
					editor: Ext.create('Ext.form.field.Text', 
						{
						msgTarget: 'side',
							validator: function(value)
							{				
								if(Weborobot.Util.isLength(value, 1, 255) == false)
								return "Путь к основному CSS сайта должен содержать от 1 до 255 символов!";
								else return true;
							},
							listeners:
							{
								blur: function(Trigger, evt, eops)
								{
								saveValue("APP_CSS", Trigger.getValue());
								}
							}
						}
					)
				},
                "Временная зона":
                {
                    editor: Ext.create('Ext.form.field.Text',
                        {
                        msgTarget: 'side',
                            validator: function(value)
                            {
                                if(Weborobot.Util.isLength(value, 1, 255) == false)
                                    return "Путь к основному CSS сайта должен содержать от 1 до 255 символов!";
                                else return true;
                            },
                            listeners:
                            {
                                blur: function(Trigger, evt, eops)
                                {
                                saveValue("APP_TIMEZONE", Trigger.getValue());
                                }
                            }
                        }
                    )
                },
                "Локаль":
                {
                    editor: Ext.create('Ext.form.field.Text',
                        {
                        msgTarget: 'side',
                            validator: function(value)
                            {
                                if(Weborobot.Util.isLength(value, 1, 255) == false)
                                    return "Путь к основному CSS сайта должен содержать от 1 до 255 символов!";
                                else return true;
                            },
                            listeners:
                            {
                                blur: function(Trigger, evt, eops)
                                {
                                saveValue("APP_LOCALE", Trigger.getValue());
                                }
                            }
                        }
                    )
                }
			};
		
		this.callParent();
		var Store = Ext.data.StoreManager.lookup("Setting");
		
			Store.load
			(
				{
					callback: function(records, operation, success)
					{
						if(success == true)
						{
						var record = records[0];
							
							thisObj.setSource
							(
								{
								"Название сайта": record.get("APP_NAME"),
								"E-mail администратора": record.get("MAIL_TO_ADDRESS"),
								"E-mail отправителя": record.get("MAIL_FROM_ADDRESS"),
								"Сайт на реконструкции": record.get("APP_SITE_RECONSTRUCTION") == 0 ? 'Нет' : 'Да',
								"Путь к основному CSS": record.get("APP_CSS"),
								"Временная зона": record.get("APP_TIMEZONE"),
                                "Локаль": record.get("APP_LOCALE")
								}
							);
						}
						else
						{
							Ext.Msg.show
							(
								{
								title: "Ошибка!",
								msg: "Произошла ошибка выполнения программы на сервере!",
								icon: Ext.MessageBox.ERROR,
								buttons: Ext.MessageBox.OK
								}
							);
						}
					}
				}
			);
		}
	}
);