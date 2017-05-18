Ext.define('Sitemap.controller.Sitemap',
	{
	extend: 'Ext.app.Controller',
	
	id: "Sitemap",

	models: ["Sitemap"],
	stores: ['Sitemap'],
	
		routes:
		{
			"section/:id":
			{
				before: function(id, action)
				{
					if(this.getStore("Sitemap").isLoaded() == false)
					{
						this.getStore("Sitemap").on("load",
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
					if(id == "Sitemap") this.setValue();
				}
			}
		},

		refs:
		{
		form: "Sitemap\\.view\\.SitemapForm"
		},
	
		control:
		{
			"Sitemap\\.view\\.Panel button[action=send]":
			{
				click: function(button)
				{
					if(button.up("panel").down("form").isValid() == true)
					{
					var thisObj = this;

					button.up("panel").mask("Загрузка...");

					var data = button.up("panel").down("form").getValues();
					var Sitemap = Ext.create(this.getModel("Sitemap"), data);
					Sitemap.setId(null);

						Sitemap.save
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

								thisObj.getStore("Sitemap").load();
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
			"Sitemap\\.view\\.Panel button[action=reset]":
			{
				click: function(button)
				{
				var form = button.up("panel").down("form");
				form.loadRecord(form.getRecord());
				}
			},
			"Sitemap\\.view\\.Panel button[action=scan]":
			{
				click: function(button)
				{
				var thisObj = this;
				button.up("panel").mask("Загрузка...");

					Ext.Ajax.request
					(
						{
						url: '_api/Sitemap/SitemapAdminController/scan/',
						timeout: 60 * 30 * 1000,
						method: "POST",
							success: function(response, options)
							{
							button.up("panel").unmask();
							var result = Ext.JSON.decode(response.responseText);

								if(result["success"] == true)
								{
									Ext.Msg.show
									(
										{
										title: "Сканирование завершено!",
										msg: "Сканирование сайта и построение sitemap.xml успешно завершено!",
										icon: Ext.MessageBox.INFO,
										buttons: Ext.MessageBox.OK
										}
									);

								thisObj.getForm().down("codemirror[name=text]").setValue(result["text"]);
								thisObj.getStore("Sitemap").reload();
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
							},
							failure: function(response, options)
							{
							button.up("panel").unmask();

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
			}
		},

		setValue: function()
		{
		var record = this.getStore("Sitemap").getById(1);
		this.getForm().getForm().loadRecord(record);
		}
	}
);