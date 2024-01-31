import React from "react";
import { Bar } from "react-chartjs-2";
import axios from "axios";
import { useState, useEffect } from "react";
import { Chart as ChartJS } from "chart.js/auto";

export default function StatistiqueTotal() {
  ///-----------------------------STATES-----------------------------///

  const [invoiceDatas, setInvoiceDatas] = useState();
  const [loading, setLoading] = useState(false);

  const [chartDatas, setChartDatas] = useState();

  ////---------------------Load Invoices Datas----------------------------////

  const token = localStorage.getItem("token");

  let mois = [
    {
      code: 1,
      label: "janvier",
    },
    {
      code: 2,
      label: "février",
    },
    {
      code: 3,
      label: "mars",
    },
    {
      code: 4,
      label: "avril",
    },
    {
      code: 5,
      label: "mai",
    },
    {
      code: 6,
      label: "juin",
    },
    {
      code: 7,
      label: "juillet",
    },
    {
      code: 8,
      label: "août",
    },
    {
      code: 9,
      label: "septembre",
    },
    {
      code: 10,
      label: "octobre",
    },
    {
      code: 11,
      label: "novembre",
    },
    {
      code: 12,
      label: "décembre",
    },
  ];

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
        const values = response.data["hydra:member"];

        //---------------tableau avec les valeur de la requête-----------------//

        const invoicesitems = values.map((item) => ({
          id: item.id,
          month: new Date(item.createdat).getMonth() + 1,
          ht: item.ht,
        }));

        /*######################## Gestion des élements par Mois ave calcul du total ########################*/

        const groupedByMonth = invoicesitems.reduce((accumulator, element) => {
          const existingItem = accumulator.find(
            (group) => group.month === element.month
          );

          if (existingItem) {
            existingItem.total += element.ht;
          } else {
            accumulator.push({
              id: element.id,
              month: element.month,
              total: element.ht,
            });
          }

          return accumulator;
        }, []);

        /*######################## ENVOIE DE LA DATA DANS CHART ########################*/

        setChartDatas({
          labels: groupedByMonth.map((data) => {
            let date = mois.filter((el) => {
              if (el.code == data.month) {
                return el.label;
              }
            });
            console.log(date.label);
            return date.map((el) => el.label);
          }),

          datasets: [
            {
              label: "Total",
              data: groupedByMonth.map((item) => item.total),

              // Use the month name if there's a match, or an empty string otherwise

              backgroundColor: ["#50AF95", "#f3ba2f", "#2a71d0"],
            },
          ],
        });

        setLoading(true);
      });
  }, []);

  return (
    <>
      {loading ? (
        <div style={{ width: "800px" }}>
          <Bar data={chartDatas} />
        </div>
      ) : null}
    </>
  );
}
