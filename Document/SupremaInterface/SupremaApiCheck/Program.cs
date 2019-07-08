﻿using System;
using System.Windows.Forms;
using FingerPrintController.DBase;

namespace SupremaApiCheck
{
    static class Program
    {
        /// <summary>
        /// The main entry point for the application.
        /// </summary>
        [STAThread]
        static void Main ()
        {
            Application.EnableVisualStyles ();
            Application.SetCompatibleTextRenderingDefault (false);
            Application.Run(new Form1());

            //FingerPrintController.FingerPrinterController.start ();
            MySqlDBase.setup ("127.0.0.1",
                              3306,
                              "iauahvaz",
                              "root",
                              "123");

            int i = Convert.ToInt32(MySqlDBase.executeScaler("Select count(*) from gatedevices"));
        }
    }
}
