import React from "react";
import { Bar } from "react-chartjs-2";
import axios from "axios";
import { useState, useEffect, useCallback } from "react";
import { Chart as ChartJS } from "chart.js/auto";

export default function StatistiqueTotal() {
  ///-----------------------------STATES-----------------------------///

  const [invoiceDatas, setInvoiceDatas] = useState();
  const [loading, setLoading] = useState(false);

  const [chartDatas, setChartDatas] = useState();

  ////---------------------Load Invoices Datas----------------------------////

  const token = localStorage.getItem("token");

  let months = [
    {
      code: 1,
      label: "janvier",
      total: null,
    },
    {
      code: 2,
      label: "février",
      total: null,
    },
    {
      code: 3,
      label: "mars",
      total: null,
    },
    {
      code: 4,
      label: "avril",
      total: null,
    },
    {
      code: 5,
      label: "mai",
      total: null,
    },
    {
      code: 6,
      label: "juin",
      total: null,
    },
    {
      code: 7,
      label: "juillet",
      total: null,
    },
    {
      code: 8,
      label: "août",
      total: null,
    },
    {
      code: 9,
      label: "septembre",
      total: null,
    },
    {
      code: 10,
      label: "octobre",
      total: null,
    },
    {
      code: 11,
      label: "novembre",
      total: null,
    },
    {
      code: 12,
      label: "décembre",
      total: null,
    },
  ];

  /*######################## GESTION STATISTIQUES ########################*/

  const [watchInvoiceItems, setWatchInvoiceItems] = useState(null);

  //useCallback pour ne pas jouer la fonction a chaque render et se lance seulement si une nouvelle facture est crée

  const initStats = useCallback(
    (groupedByMonth, months) => {
      groupedByMonth.map((el) => {
        let findMonth = months.filter((months) => {
          if (months.code == el.month) {
            months.total = el.total;
          }
        });
        console.log("yes");
        return findMonth;
      });
    },
    [watchInvoiceItems]
  );

  console.log("render");
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

        /*######################## TABLEAU D'OBJETS CONTENANT LES VALEURS POUR LE TRAITEMENT ########################*/

        const invoicesitems = values.map((item) => ({
          id: item.id,
          month: new Date(item.createdat).getMonth() + 1,
          ht: item.ht,
        }));

        /*######################## CALCUL DU TOTAL EN FONCTION DU months ########################*/

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

        /*######################## INITIALISATION DU TABLEAU ########################*/

        initStats(groupedByMonth, months);

        /*######################## ENVOIE DE LA DATA DANS CHART ########################*/
        setChartDatas({
          labels: months.map((item) => item.label),

          datasets: [
            {
              label: "Total",
              data: months.map((item) => item.total),
              backgroundColor: ["#50AF95", "#f3ba2f", "#2a71d0", "#5bc0eb"],
            },
          ],
        });
        setWatchInvoiceItems(invoicesitems);
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
