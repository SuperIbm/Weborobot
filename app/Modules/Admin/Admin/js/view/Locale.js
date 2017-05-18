Ext.define('Admin.view.Locale',
	{
	singleton: true,
	_locale: "ru",

		_locales:
		{
			ru:
			{
			label: "Русский",
			icon: "component/Admin/admin/images/locale/ru.png"
			},
			en:
			{
			label: "English",
			icon: "component/Admin/admin/images/locale/en.png"
			}
		},

		constructor: function()
		{
		var params = Ext.Object.fromQueryString(window.location.search.substring(1)), locale;

			if(params.lang) locale = params.lang;
			else if(Ext.util.Cookies.get("locale")) locale = Ext.util.Cookies.get("locale");

		var me = this;

			if(locale)
			{
				this.load("extJs/classic/locale/locale-" + locale + ".js",
					function(success)
					{
						if(success == false)
						{
							Ext.Msg.show
							(
								{
								title: "Ошибка!",
								msg: "Произошла ошибка подгрузки файла локали. Будет использована локаль по умолчанию.",
								icon: Ext.MessageBox.ERROR,
								buttons: Ext.MessageBox.OK
								}
							);
						}
						else
						{
						me.set(locale);
						}
					}
				);
			}
		},
		load: function(url, callback)
		{
		var me = this;

			Ext.Ajax.request
			(
				{
				url: url,
				method: "GET",
				async: false,
					success: function(response, options)
					{
						try
						{
						eval(response.responseText);

							if(callback) callback.call(me, true);
						}
						catch(er)
						{
							if(callback) callback.call(me, false);
						}
					},
					failure: function(response, options)
					{
						if(callback) callback.call(me, false);
					}
				}
			);
		},
		get: function()
		{
		return this._locale;
		},
		set: function(locale)
		{
		this._locale = locale;

		var Dt = new Date();
		Dt.setFullYear(Dt.getFullYear() + 20);
		Ext.util.Cookies.set("locale", locale, Dt);

		return this;
		},
		getParams: function(locale)
		{
			if(this._locales[locale]) return this._locales[locale];
			else return false;
		},
		getLolals: function()
		{
		return this._locales
		}
	}
);