Ext.define('Robots.controller.Robots',
	{
	extend: 'Ext.app.Controller',
	
	id: "Robots",

	models: ["Robots"],
	stores: ['Robots'],
	
		routes:
		{
			"section/:id":
			{
				before: function(id, action)
				{
					if(this.getStore("Robots").isLoaded() == false)
					{
						this.getStore("Robots").on("load",
							function()
							{
							action.resume();
							},
							null,
							{
							single: true
							}
						);
					}
					else action.resume();
				},
				action: function(id)
				{
					if(id == "Robots") this.setValue();
				}
			}
		},

		refs:
		{
		form: "Robots\\.view\\.RobotsForm"
		},
	
		control:
		{
			"Robots\\.view\\.Panel button[action=send]":
			{
				click: function(button)
				{
					if(button.up("panel").down("form").isValid() == true)
					{
					var thisObj = this;

					button.up("panel").mask("Загрузка...");

					var data = button.up("panel").down("form").getValues();
					var Robots = Ext.create(this.getModel("Robots"), data);
					Robots.setId(null);

						Robots.save
						(
							{
								success: function(model, operation)
								{
								button.up("panel").unmask();

									Ext.Msg.show
									(
										{
										title: "Данные изменены!",
										msg: "Введенные вами данные были удачно изменены!",
										icon: Ext.MessageBox.INFO,
										buttons: Ext.MessageBox.OK
										}
									);

								thisObj.getStore("Robots").load();
								},
								failure: function(model, operation)
								{
								var result = Ext.decode(operation.getResponse().responseText);
								button.up("panel").unmask();

									if(result.errormsg)
									{
										Ext.Msg.show
										(
											{
											title: "Ошибка!",
											msg: result.errormsg,
											icon: Ext.MessageBox.ERROR,
											buttons: Ext.MessageBox.OK
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
					else
					{
						Ext.Msg.show
						(
							{
							title: "Предупреждение!",
							msg: "Некоторые поля в форме заполнены некорректно!",
							icon: Ext.MessageBox.WARNING,
							buttons: Ext.MessageBox.OK
							}
						);
					}
				}
			},
			"Robots\\.view\\.Panel button[action=reset]":
			{
				click: function(button)
				{
				var form = button.up("panel").down("form");
				form.loadRecord(form.getRecord());
				}
			}
		},

		setValue: function()
		{
		var record = this.getStore("Robots").getById(1);
		this.getForm().getForm().loadRecord(record);
		}
	}
);