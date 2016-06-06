package md52fa19b15c61d4f6d44d897f0c0f85ecc;


public class ScheduledAlarmHandler
	extends android.content.BroadcastReceiver
	implements
		mono.android.IGCUserPeer
{
	static final String __md_methods;
	static {
		__md_methods = 
			"n_onReceive:(Landroid/content/Context;Landroid/content/Intent;)V:GetOnReceive_Landroid_content_Context_Landroid_content_Intent_Handler\n" +
			"";
		mono.android.Runtime.register ("LocalNotifications.Plugin.ScheduledAlarmHandler, LocalNotifications.Plugin, Version=1.0.0.0, Culture=neutral, PublicKeyToken=null", ScheduledAlarmHandler.class, __md_methods);
	}


	public ScheduledAlarmHandler () throws java.lang.Throwable
	{
		super ();
		if (getClass () == ScheduledAlarmHandler.class)
			mono.android.TypeManager.Activate ("LocalNotifications.Plugin.ScheduledAlarmHandler, LocalNotifications.Plugin, Version=1.0.0.0, Culture=neutral, PublicKeyToken=null", "", this, new java.lang.Object[] {  });
	}


	public void onReceive (android.content.Context p0, android.content.Intent p1)
	{
		n_onReceive (p0, p1);
	}

	private native void n_onReceive (android.content.Context p0, android.content.Intent p1);

	java.util.ArrayList refList;
	public void monodroidAddReference (java.lang.Object obj)
	{
		if (refList == null)
			refList = new java.util.ArrayList ();
		refList.add (obj);
	}

	public void monodroidClearReferences ()
	{
		if (refList != null)
			refList.clear ();
	}
}
