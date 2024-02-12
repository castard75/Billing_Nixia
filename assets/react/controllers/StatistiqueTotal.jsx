import React from "react";
import { Bar } from "react-chartjs-2";
import axios from "axios";
import { useState, useEffect, useCallback, Suspense } from "react";
import { Chart as ChartJS } from "chart.js/auto";
import { months } from "../../utils/monthsList";

export default function StatistiqueTotal() {
  /*######################## STATES ########################*/

  const [invoiceDatas, setInvoiceDatas] = useState();
  const [loading, setLoading] = useState(false);

  const [chartDatas, setChartDatas] = useState();

  /*######################## Load Invoices Datas ########################*/

  const token = localStorage.getItem("token");

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

        return findMonth;
      });
    },
    [watchInvoiceItems]
  );

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
              label: "Montant total facturé",
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

const SuspendedUpdateContract = (props) => (
  <Suspense fallback={<div>Loading...</div>}>
    <StatistiqueTotal />
  </Suspense>
);
