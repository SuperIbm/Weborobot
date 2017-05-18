Ext.define('User.view.UserAccountGrid', 
	{
	extend: 'Admin.view.ux.GridPanel',
	alias: 'widget.User.view.UserAccountGrid',
	
		requires:
		[
		"User.view.field.UserAccountFirstnameText",
		"User.view.field.UserAccountSecondnameText",
		"User.view.field.UserAccountLastnameText",
		"User.view.field.UserAccountEmailText",
		"User.view.field.UserAccountTelephoneText",
		"User.view.field.UserAccountSexComboBox",
		"User.view.field.UserAccountBirthdayDatefield",
		"User.view.field.UserAccountIcqText",
		"User.view.field.UserAccountSkypeText",
		
		"User.view.field.UserAccountPassportSeriaAndNumberText",
		"User.view.field.UserAccountPassportWhoMadeText",
		"User.view.field.UserAccountPassportWhenMadeDatefield",
		"User.view.field.UserAccountPassportCodeSectionText",
		"User.view.field.UserAccountPassportAdressText",
		
		"User.view.field.UserAccountOrganFormaText",
		"User.view.field.UserAccountOrganNameText",
		"User.view.field.UserAccountOrganAboutTextArea",
		"User.view.field.UserAccountSiteText",
		
		"User.view.field.UserAccountStatusComboBox",
		"User.view.field.UserAccountLoginText",
		"User.view.field.UserAccountPasswordTriggerFieldGeneratePassword",
		
		"User.view.field.UserAccountZipText",
		"User.view.field.UserAccountCountryText",
		"User.view.field.UserAccountCityText",
		"User.view.field.UserAccountStreetText"
		],
	
	name: "User",
	store: "UserAccount",
	
		dockedItems:
		[
			{
			xtype: 'pagingtoolbar',
			store: 'UserAccount',
			dock: 'bottom',
			displayInfo: true
			}
		],
	
		columns:
		[
			{
			header: 'ID',
			dataIndex: "idUser",
			filter: "number",
			width: "5%"
			},
			
			{
			header: 'Изоб.',
			dataIndex: "idImageSmall",
			width: "6%",
			filter: "image",
				renderer: function(val)
				{
					if(val) return "<img src='engine/app/Modules/Admin/Admin/images/icon_image.png' width='15' height='15' />";
					else return "";		
				}
			},
			{
			header: 'Логин',
			dataIndex: "login",
			filter: "string",
			width: "10%",
				editor: 
				{
				xtype: "User.view.field.UserAccountLoginText",
				hideLabel: true	
				}
			},
			{
			header: 'Пароль',
			dataIndex: "password",
			filter: "string",
			hidden: true,
				editor: 
				{
				xtype: "User.view.field.UserAccountPasswordTriggerFieldGeneratePassword",
				hideLabel: true	
				}
			},
			
			{
			header: 'Имя',
			dataIndex: "firstname",
			filter: "string",
			width: "11%",
				editor: 
				{
				xtype: "User.view.field.UserAccountFirstnameText",
				hideLabel: true	
				}
			},
			{
			header: 'Фамилия',
			dataIndex: "secondname",
			filter: "string",
			width: "11%",
				editor: 
				{
				xtype: "User.view.field.UserAccountSecondnameText",
				hideLabel: true	
				}
			},
			{
			header: 'Отчество',
			dataIndex: "lastname",
			filter: "string",
			hidden: true,
				editor: 
				{
				xtype: "User.view.field.UserAccountLastnameText",
				hideLabel: true	
				}
			},
			{
			header: 'E-mail',
			dataIndex: "email",
			filter: "string",
			hidden: true,
				editor: 
				{
				xtype: "User.view.field.UserAccountEmailText",
				hideLabel: true	
				}
			},
			{
			header: 'Телефон',
			dataIndex: "telephone",
			filter: "string",
			hidden: true,
				editor: 
				{
				xtype: "User.view.field.UserAccountTelephoneText",
				hideLabel: true	
				}
			},
			{
			header: 'Пол',
			dataIndex: "sex",
			filter: "string",
			hidden: true,
				editor: 
				{
				xtype: "User.view.field.UserAccountSexComboBox",
				hideLabel: true	
				}
			},
			{
			header: 'День рождения',
			dataIndex: "birthday",
            xtype: 'datecolumn',
            format: "d.m.Y",
                filter:
                {
                type: 'date',
                dateFormat: "Y-m-d"
                },
			hidden: true,
				editor:
				{
				xtype: "User.view.field.UserAccountBirthdayDatefield",
				hideLabel: true	
				}
			},
			{
			header: 'ICQ',
			dataIndex: "icq",
			filter: "string",
			hidden: true,
				editor: 
				{
				xtype: "User.view.field.UserAccountIcqText",
				hideLabel: true	
				}
			},
			{
			header: 'Skype',
			dataIndex: "skype",
			filter: "string",
			hidden: true,
				editor: 
				{
				xtype: "User.view.field.UserAccountSkypeText",
				hideLabel: true	
				}
			},
			
			{
			header: 'Индекс',
			dataIndex: "zip",
			filter: "string",
			hidden: true,
				editor: 
				{
				xtype: "User.view.field.UserAccountZipText",
				hideLabel: true	
				}
			},
			{
			header: 'Страна',
			dataIndex: "country",
			filter: "string",
			hidden: true,
				editor: 
				{
				xtype: "User.view.field.UserAccountCountryText",
				hideLabel: true	
				}
			},
			{
			header: 'Город',
			dataIndex: "city",
			filter: "string",
			hidden: true,
				editor: 
				{
				xtype: "User.view.field.UserAccountCityText",
				hideLabel: true	
				}
			},
			{
			header: 'Адрес',
			dataIndex: "street",
			filter: "string",
			hidden: true,
				editor: 
				{
				xtype: "User.view.field.UserAccountStreetText",
				hideLabel: true	
				}
			},
			
			{
			header: 'Форма организации',
			dataIndex: "organForma",
			filter: "string",
			hidden: true,
				editor: 
				{
				xtype: "User.view.field.UserAccountOrganFormaText",
				hideLabel: true	
				}
			},
			{
			header: 'Название организации',
			dataIndex: "organName",
			filter: "string",
			hidden: true,
				editor: 
				{
				xtype: "User.view.field.UserAccountOrganNameText",
				hideLabel: true	
				}
			},
			{
			header: 'Сайт',
			dataIndex: "site",
			filter: "string",
			hidden: true,
				editor: 
				{
				xtype: "User.view.field.UserAccountSiteText",
				hideLabel: true	
				}
			},
			
			{
			header: 'Серия и номер паспорта',
			dataIndex: "passportSeriaAndNumber",
			filter: "string",
			hidden: true,
				editor: 
				{
				xtype: "User.view.field.UserAccountPassportSeriaAndNumberText",
				hideLabel: true	
				}
			},
			{
			header: 'Кем выдан паспорт',
			dataIndex: "passportWhoMade",
			filter: "string",
			hidden: true,
				editor: 
				{
				xtype: "User.view.field.UserAccountPassportWhoMadeText",
				hideLabel: true	
				}
			},
			{
			header: 'Когда выдан паспорт',
			dataIndex: "passportWhenMade",
            xtype: 'datecolumn',
            format: "d.m.Y",
                filter:
                {
                type: 'date',
                dateFormat: "Y-m-d"
                },
            hidden: true,
                editor:
                {
                xtype: "User.view.field.UserAccountPassportWhenMadeDatefield",
                hideLabel: true
                }
			},
			{
			header: 'Код подразделения паспорта',
			dataIndex: "passportCodeSection",
			filter: "string",
			hidden: true,
				editor: 
				{
				xtype: "User.view.field.UserAccountPassportCodeSectionText",
				hideLabel: true	
				}
			},
			{
			header: 'Прописка по паспорту',
			dataIndex: "passportAdress",
			filter: "string",
			hidden: true,
				editor: 
				{
				xtype: "User.view.field.UserAccountPassportAdressText",
				hideLabel: true	
				}
			},
			
			{
			header: 'Регистрация',
			dataIndex: "dateAdd",
			xtype: 'datecolumn',
			format: "j F Y, H:i",
			width: "11%",
				filter:
				{
				type: 'date',
				dateFormat: "Y-m-d"
				}
			},
			{
			header: 'Последний вход',
			dataIndex: "dateLastEnter",
			xtype: 'datecolumn',
			format: "j F Y, H:i",
			width: "11%",
                filter:
                {
                type: 'date',
                dateFormat: "Y-m-d"
                }
			},
			{
			header: 'IP',
			dataIndex: "ip",
			filter: "string",
			width: "10%"
			},
			
			{
			header: 'Группы',
			dataIndex: "groups",
			width: "10%",
                renderer: function(val, x, rec)
                {
                    if(rec.get("groups"))
                    {
                        var value = "",
                            groups = rec.get("groups");

                        for(var i = 0; i < groups.length; i++)
                        {
                            if(groups[i]["usergroup"])
                            {
                                if(value != "") value += ", ";

                                for(var y = 0; y < groups[i]["usergroup"].length; y++)
                                {
                                    value += groups[i]["usergroup"][y]["nameGroup"];
                                }
                            }
                        }

                        return value;
                    }
                    else return "";
                }
			},
			
			{
			header: 'Статус',
			dataIndex: "status",
			filter: "boolean",
			width: "10%",
				editor: 
				{
				xtype: "User.view.field.UserAccountStatusComboBox",
				hideLabel: true	
				}
			}
		],
		listeners: 
		{
			beforeEditUpdate: function(editor, context)
			{	
				if(context.field == "user.status")
				{
				context.grid.mask("Загрузка...");
				context.record.set("status", context.value);
					
					context.record.save
					(
						{
							success: function(model, operation)
							{
							context.record.commit();
							context.grid.unmask();
							},
							failure: function(model, operation)
							{
							context.record.reject();
							context.grid.unmask();
							
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
				
				return false;
				}
				else return true;	
			}
		},
		initComponent: function()
		{
			this.buttonCreate = 
			{
			text: "Добавить",
			hidden: !Admin.getApplication().Access.is("User", "isCreate")
			};
			
			this.buttonUpdate = 
			{
			text: "Изменить",
			hidden: !Admin.getApplication().Access.is("User", "isUpdate")
			};
			
			this.buttonDestroy = 
			{
			text: "Удалить",
			hidden: !Admin.getApplication().Access.is("User", "isDestroy")
			};
		
		this.callParent();
		}
	}
);