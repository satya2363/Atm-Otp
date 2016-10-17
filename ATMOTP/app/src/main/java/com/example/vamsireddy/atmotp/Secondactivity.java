package com.example.vamsireddy.atmotp;

import android.app.ProgressDialog;
import android.content.Intent;
import android.os.AsyncTask;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;


public class Secondactivity extends ActionBarActivity {

    private EditText ammount;
    private EditText password;
    private ProgressDialog pDialog;
    JSONParser jsonParser = new JSONParser();
    private static final String LOGIN_URL = "http://teamkites.org/otp/otpconnect.php";
    private Button submit22;

    ConnectionDetector cd;
    Boolean isInternetPresent = false;

    private static final String TAG_SUCCESS = "success";
    private static final String TAG_MESSAGE = "message";
    private static final String TAG_OTP="otp";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.pinandammount);

        ammount=(EditText)findViewById(R.id.ammount);
        password=(EditText)findViewById(R.id.password);
        submit22=(Button)findViewById(R.id.submit2);

        submit22.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                cd = new ConnectionDetector(getApplicationContext());
                isInternetPresent = cd.isConnectingToInternet();
                if(isInternetPresent) {

                    Logic.pinno = password.getText().toString();
                    Logic.ammount = ammount.getText().toString();

                    new RequestOtp().execute();



                }
                else{
                    Toast.makeText(Secondactivity.this, "Please Check You Internet Connectivity!", Toast.LENGTH_LONG).show();



                }

            }
        });





    }


    class RequestOtp extends AsyncTask<String, String, String> {


        /**
         * Before starting background thread Show Progress Dialog
         * */
        boolean failure = false;

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            pDialog = new ProgressDialog(Secondactivity.this);
            pDialog.setMessage("Requesting OTP...");
            pDialog.setIndeterminate(false);
            pDialog.setCancelable(true);
            pDialog.show();
        }

        @Override
        protected String doInBackground(String... args) {
            // TODO Auto-generated method stub
            // Check for success tag
            int success;

            try {
                // Building Parameters
                List<NameValuePair> params = new ArrayList<NameValuePair>();
                params.add(new BasicNameValuePair("cardno", Logic.cardno));
                params.add(new BasicNameValuePair("pin", Logic.pinno));
                params.add(new BasicNameValuePair("amt",Logic.ammount));

                Log.d("request!", "starting");
                // getting product details by making HTTP request
                JSONObject json = jsonParser.makeHttpRequest(
                        LOGIN_URL, "POST", params);

                // check your log for json response
                Log.d("Login attempt", json.toString());


                // json success tag
                success = json.getInt(TAG_SUCCESS);
                if (success == 1) {
                    Logic.OTP=json.getString(TAG_OTP);
                    Intent i = new Intent(Secondactivity.this, Thirdactivity.class);
                    finish();
                    startActivity(i);


                    return json.getString(TAG_MESSAGE);
                }
                if(success == 2){

                  //  ammount.setText("");
                   // password.setText("");
                    Intent i = new Intent(Secondactivity.this, Secondactivity.class);
                    finish();
                    startActivity(i);

                 //   Toast.makeText(Secondactivity.this, "Your Balance is Low to generate OTP", Toast.LENGTH_LONG).show();

                    return json.getString(TAG_MESSAGE);


                }
                if(success == 3){
                   // cardnumber.setText("");
                  //  ammount.setText("");
                   // password.setText("");
                    Intent i = new Intent(Secondactivity.this, MainActivity.class);
                    finish();
                    startActivity(i);

                    return json.getString(TAG_MESSAGE);


                 //   Toast.makeText(Secondactivity.this, "OTP active for this acoount", Toast.LENGTH_LONG).show();

                }
                if(success == 4){

                    Intent i = new Intent(Secondactivity.this, MainActivity.class);
                    finish();
                    startActivity(i);

                    return json.getString(TAG_MESSAGE);
                 //   Toast.makeText(Secondactivity.this, "INVALID CARD NUMBER OR PIN", Toast.LENGTH_LONG).show();

                }

            } catch (JSONException e) {
                e.printStackTrace();
            }

            return null;

        }
        /**
         * After completing background task Dismiss the progress dialog
         * **/
        protected void onPostExecute(String file_url) {
            // dismiss the dialog once product deleted
            pDialog.dismiss();
            if (file_url != null){
                Toast.makeText(Secondactivity.this, file_url, Toast.LENGTH_LONG).show();
            }

        }


    }







    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_secondactivity, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }
}
