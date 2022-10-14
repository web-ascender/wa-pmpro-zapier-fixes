# Paid Membership Pro Zapier Plugin "fixes"

**The PMPro Zapier WordPress plugin had some issues that was making it hard to use with Zapier**

By default each of the Paid Membership Pro web hooks used lots of different tokens and information to pass to Zapier depending on the hook.  On the version I was using there was an issue where email was not even getting passed to Zapier.

This plugin hooks the Paid Membership Pro filters that allow you to manipulate the $data prior to passing it over to Zapier. During this filter we add the tokens that we wanted to pass over to HubSpot CRM.  These tokens are named:

- wp_user_id
- wp_username
- wp_email
- wp_first_name
- wp_last_name
- wp_membership_id
- wp_membership_status

Previously if the default Zapier hook even had a membership_id it would be named something different in different hooks, some didn't include a membership status. None of them included the WordPress users name / email or other details about the WordPress user.

Had to resort to using the "older" mechanism to integrate with Zapier using their Webhook strategy and this older way of integrating Paid Membership Pro. There is a newer integration with Zaprier that they have created but that also had a myriad of issues and this strategy was easier to test, diagnose, and override for fixes.

If you are having trouble integrating Paid Membership Pro with Zapier you can give this plugin a try. Simply download this directory and add it into you wp-content/plugins area. Then enable it in your WordPress plugins in your dashboard. You'll also need the PMPRO Zapier add-on installed.

You can enable all the hooks and send all the hooks to the same Zapier endpoint as long as you only use the wp_ fields above that should work fine.

When integrating with HubSpot we used the:  "Find or Create Contact" by email. 
On each hook this will find the existing HubSpot entry by wp_email and then update their content or if it's new, it will create the HubSpot contact.

https://www.paidmembershipspro.com/

https://www.paidmembershipspro.com/add-ons/pmpro-zapier/

PMPro Zapier version at the time of this implementation: 1.2.1

It's quite possible in the future, if this add-on is still maintained by Paid Membership Pro that they'll standardize the information that comes across in each hook better. 
