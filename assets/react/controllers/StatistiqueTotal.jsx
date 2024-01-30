import React from "react";
import { Bar } from "react-chartjs-2";
import axios from "axios";
import { useState, useEffect } from "react";

export default function StatistiqueTotal() {
  const [invoices, setInvoices] = useState({
    labels: "invoices",
    datasets: [
      {
        label: "test",
        data: 245,
      },
    ],
  });

  ////---------------------Load Invoices Datas----------------------------////

  const token = localStorage.getItem("token");
  console.log(token);

  useEffect(() => {
    axios
      .request({
        headers: {
          Authorization: `Bearer ${token}`,
        },
        method: "GET",
        url: `https://localhost:8000/api/invoicesitems`,
      })
      .then((response) => {
        console.log(response.data);
        const data = response.data;
      });
  }, []);

  return <div></div>;
}
