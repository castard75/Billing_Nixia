import React from "react";
import axios from "axios";
import { useState, useEffect, useRef } from "react";
import { useForm, SubmitHandler } from "react-hook-form";
import * as yup from "yup";
import { yupResolver } from "@hookform/resolvers/yup";
import swal from "sweetalert";
import ReactPaginate from "react-paginate";
import validator from "validator";

export default function UsersPage() {
  const [list, setList] = useState([]);
  const [showModal, setShowModal] = useState(false);
  const [selectedItem, setSelectedItem] = useState(null);
  const [showUpdate, setShowUpdate] = useState(false);
  const [message, setMessage] = useState("");

  ////################################ STATE UPDATE ################################////

  const [email, setEmail] = useState("");
  const [name, setName] = useState("");

  ///-------------Search------------///
  const [search, setSearch] = useState("");

  ////################################ UTILISATEUR ################################////

  const token = localStorage.getItem("token");

  useEffect(() => {
    axios
      .request({
        headers: {
          Authorization: `Bearer ${token}`,
        },
        method: "GET",
        url: "https://localhost:8000/api/users",
      })
      .then((res) => {
        const data = res.data["hydra:member"];
        const activData = data.filter((el) => {
          return el.deletedat == null;
        });

        setList(activData);
      })
      .catch((err) => console.log(err));
  }, []);

  ////################################ close modal################################ ////
  const closeModal = () => {
    setShowModal(false);
    setShowUpdate(false);
  };

  ////################################ UPDATE ################################ ////

  const viewDetails = (id) => {
    const findObjList = list.find((el) => el.id === id);

    setSelectedItem(findObjList);

    setValue("name", findObjList.name);
    setValue("email", findObjList.email);

    setShowModal(true);
  };

  ////################################ VALIDATION FORM ################################////

  const { register, handleSubmit, formState, setValue } = useForm();

  const { errors } = formState;

  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  // const isValidEmail = (email) => {
  //   return emailRegex.test(email);
  // };

  ////################################ UPDATE ################################////

  const handleChange = (data, e) => {
    // if (!isValidEmail(data.email)) {
    //   console.log("Adresse e-mail invalide");
    //   return;
    // }

    if (validator.isEmail(data.email)) {
      e.preventDefault();
      const name = data.name;
      const email = data.email;

      ///gestion date
      let dates = new Date();
      const iso = dates.toISOString();
      const hours = iso.split("T")[1].split(".")[0];

      const date = iso.split("T")[0];
      const finalDate = date + " " + hours;

      console.log(email);
      const obj = {
        name: name,
        email: email,
        updatedat: finalDate,
      };

      axios
        .put(`https://localhost:8000/api/users/${selectedItem.id}`, obj, {
          headers: {
            "Content-Type": "application/ld+json",
            Authorization: `Bearer ${token}`,
          },
        })
        .then((response) => {
          console.log(response.data);
          window.location = "/users";
        })
        .catch((error) => {
          console.error(error);
        });
    } else {
      setMessage("Veuillez entrer un email valide svp!");
      setTimeout(() => {
        setMessage("");
      }, 4000);
      return false;
    }
  };

  ////################################ DELETE ################################////

  const handleDelete = (e, id) => {
    e.preventDefault();

    console.log(id);

    const idToDelete = id;

    let findItem = list.find((item) => {
      return item.id == id;
    });

    let dates = new Date();
    const iso = dates.toISOString();
    const hours = iso.split("T")[1].split(".")[0];

    const date = iso.split("T")[0];
    const finalDate = date + " " + hours;

    const objToPut = {
      deletedat: finalDate,
    };

    axios
      .put(`https://localhost:8000/api/users/${id}`, objToPut, {
        headers: {
          "Content-Type": "application/ld+json",
          Authorization: `Bearer ${token}`,
        },
      })
      .then((response) => {
        console.log(response.data);
        const newList = list.filter((element) => {
          return element.id !== id;
        });

        setList(newList);
      })
      .catch((error) => {
        console.error(error);
      });
  };

  const [page, setPage] = useState(0);
  const [filterData, setFilterData] = useState();
  const n = 3;

  useEffect(() => {
    setFilterData(
      list.filter((item, index) => {
        return (index >= page * n) & (index < (page + 1) * n);
      })
    );
  }, [page, list]); //depence de list car le useEffect est monter avant que lsit soit à jour

  return (
    <>
      <section className="vh-100 gradient-custom-2 test">
        <div className="container py-5 ">
          {" "}
          <div className="row d-flex justify-content-center align-items-center h-100">
            <div className="col-md-12 col-xl-10">
              <div className="card mask-custom">
                <div className="card-body p-4 text-white">
                  <div
                    className=" mb-2"
                    style={{ paddingRight: "1rem", width: "300px" }}
                  >
                    <i className="ki-outline ki-magnifier fs-3 text-primary position-absolute top-50 translate-middle ms-9"></i>

                    <input
                      style={{ paddingRight: "1rem", width: "200px" }}
                      type="text"
                      className="form-control form-control-sm form-control-lg form-control-solid ps-14"
                      name="search"
                      id="ZoneRechercheTableTiers"
                      onChange={(e) => setSearch(e.target.value)}
                      placeholder="Recherche"
                    />
                  </div>
                  <table className="table text-white mb-0">
                    <thead>
                      <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Email</th>

                        <th scope="col">Edit</th>
                        <th scope="col">Désactivé</th>
                      </tr>
                    </thead>
                    <tbody>
                      {filterData
                        ?.filter((item) => {
                          return search.toLowerCase() === ""
                            ? item
                            : item.email.toLowerCase().includes(search);
                        })
                        .map((item) => {
                          return (
                            <tr className="align-middle" key={item.id}>
                              <td>
                                <span className="ms-2">{item.name}</span>
                              </td>
                              <td className="align-middle">
                                <span>{item.email}</span>
                              </td>

                              <td
                                className="align-middle"
                                onClick={() => viewDetails(item.id)}
                              >
                                <button
                                  type="button"
                                  className="btn btn-primary"
                                  data-toggle="modal"
                                  data-target="#detail"
                                >
                                  <i className="bi bi-pencil"></i>
                                </button>
                              </td>
                              <td className="align-middle">
                                <button
                                  type="button"
                                  className="btn btn-danger"
                                  onClick={(e) => handleDelete(e, item.id)}
                                >
                                  <i className="bi bi-trash3-fill"></i>
                                </button>
                              </td>
                            </tr>
                          );
                        })}
                    </tbody>
                  </table>
                  <div
                    style={{ display: "flex", justifyContent: "flex-start" }}
                  >
                    <ReactPaginate
                      containerClassName={"pagination"}
                      pageClassName={"CustomStyles"}
                      activeClassName={"active"}
                      onPageChange={(event) => setPage(event.selected)}
                      pageCount={Math.ceil(list.length / n)}
                      breakLabel="..."
                      previousLabel={"précédent"}
                      nextLabel={"suivant"}
                      marginPagesDisplayed={2}
                      nextClassName={"item  "}
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <main id="main" className="main">
        <div
          className={`modal fade ${showModal ? "show" : ""}`}
          id="detail"
          tabIndex="-1"
          role="dialog"
          aria-labelledby="details"
          aria-hidden={!showModal}
          style={{ display: showModal ? "block" : "none" }}
        >
          <div className="modal-dialog" role="document">
            <div className="modal-content">
              <div className="modal-header">
                <button
                  type="button"
                  className="close btn btn-secondary"
                  data-dismiss="modal"
                  aria-label="Close"
                  onClick={closeModal}
                >
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div className="modal-body">
                <ul className="list-group list-group-flush">
                  <li className="list-group-item">
                    <h6>Nom</h6>
                    <input
                      {...register("name", { required: true })}
                      type="text"
                      className="form-control"
                      id="exampleFormControlInput1"
                      onChange={(e) => {
                        const selectedValue =
                          e.target.value === undefined
                            ? selectedItem?.name
                            : e.target.value;
                        setName(selectedValue);
                      }}
                    />
                    {errors.name && (
                      <span style={{ color: "red" }}>
                        Ce champ est obligatoire
                      </span>
                    )}
                  </li>
                  <li className="list-group-item">
                    <h6>Email</h6>
                    <input
                      {...register("email", {
                        required: true,
                      })}
                      type="email"
                      className="form-control"
                      id="exampleFormControlInput1"
                      onChange={(e) => {
                        const selectedValue =
                          e.target.value === undefined
                            ? selectedItem?.email
                            : e.target.value;
                        setEmail(selectedValue);
                      }}
                    />
                    {errors.email && (
                      <span style={{ color: "red" }}>
                        Veuillez entrer un email valide svp!
                      </span>
                    )}
                    <span
                      style={{
                        color: "red",
                        display: errors.email ? "none" : "block",
                      }}
                      id="test"
                    >
                      {message}
                    </span>
                  </li>
                </ul>
                <div className="modal-footer">
                  <button
                    type="button"
                    className="btn btn-secondary"
                    onClick={closeModal}
                  >
                    Annuler
                  </button>
                  <button
                    type="button"
                    className="btn "
                    style={{ background: "#38ad69" }}
                    onClick={handleSubmit(handleChange)}
                  >
                    Valider
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
      ;
    </>
  );
}
