import React from "react";
import axios from "axios";
import { useState, useEffect, useRef } from "react";
import { useForm, SubmitHandler } from "react-hook-form";

import ReactPaginate from "react-paginate"; // for pagination

// import { DataTable } from "primereact/datatable";
// import { Column } from "primereact/column";

export default function UsersPage() {
  ////-----------------USE CONTEXT -------------------------////

  const [list, setList] = useState([]);
  const [showModal, setShowModal] = useState(false);
  const [selectedItem, setSelectedItem] = useState(null);
  const [showUpdate, setShowUpdate] = useState(false);

  ////----------STATE UPDATE----------////
  const [technicien, setTechnicien] = useState("");
  const [client, setClient] = useState("");
  const [allClients, setAllClients] = useState([]);
  const [allTechniciens, setAllTechniens] = useState([]);
  const [title, setTitle] = useState("");
  const [description, setDescription] = useState("");
  const [recurrence, setRecurrence] = useState();
  const [allGroup, setAllGroup] = useState([]);
  const [group, setGroup] = useState([]);
  const [email, setEmail] = useState("");
  const [name, setName] = useState("");

  ///-------------Search------------///
  const [search, setSearch] = useState("");

  ////-------------------------REF----------------------////

  const idInputRef = useRef(null);

  ////----------------------VALIDATION FORM------------------------////

  const { register, handleSubmit, formState, setValue } = useForm({});

  const { errors } = formState;

  ////-------------------UTILISATEUR-------------------------////

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

        setList(data);
      })
      .catch((err) => console.log(err));
  }, []);

  ////-------------UPDATE-----------------////

  const viewDetails = (id) => {
    const findObjList = list.find((el) => el.id === id);

    setSelectedItem(findObjList);

    setValue("name", findObjList.name);
    setValue("email", findObjList.email);

    setShowModal(true);
  };

  const handleUpdate = () => {
    setShowUpdate(true);
  };

  ////-------------close modal------------////
  const closeModal = () => {
    setShowModal(false);
    setShowUpdate(false);
  };

  ////---------------HANDLE CHANGE----------------------////

  const handleChange = (data, e) => {
    e.preventDefault();
    const name = data.name;
    const email = data.email;

    console.log(name);
    console.log(email);

    const obj = {
      name: name,
      email: email,
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
  };

  ////----------------------DELETE-----------------------////

  //   const handleDelete = (e, id) => {
  //     e.preventDefault();

  //     const idToDelete = id;

  //     let findItem = list.find((item) => {
  //       return item.id == id;
  //     });
  //     console.log(findItem);
  //     let dates = new Date();
  //     const iso = dates.toISOString();
  //     const hours = iso.split("T")[1].split(".")[0];

  //     const date = iso.split("T")[0];
  //     const finalDate = date + " " + hours;

  //     const objToPut = {};

  //     axios
  //       .put(`https://localhost:8000/api/tasks/${idToDelete}`, objToPut, {
  //         headers: {
  //           "Content-Type": "application/ld+json",
  //         },
  //       })
  //       .then((response) => {
  //         console.log(response.data);
  //         const newList = list.filter((element) => {
  //           return element.id !== idToDelete;
  //         });

  //         setList(newList);
  //         // window.location = "/";
  //       })
  //       .catch((error) => {
  //         console.error(error);
  //       });
  //   };

  const [page, setPage] = useState(0);
  const [filterData, setFilterData] = useState([]);
  const n = 3;

  useEffect(() => {
    setFilterData(
      list.filter((item, index) => {
        return (index >= page * n) & (index < (page + 1) * n);
      })
    );
  }, [page]);

  // const active = {
  //   backgroundColor: "#1e50ff",
  //   borderRadius: "50%",
  // };

  // const CustomStyles = {
  //   listStyle: "none",
  //   padding: "2px 12px",
  //   height: "31.5px",
  //   width: "31.5px",
  //   display: "flex",
  //   justifyContent: "center",
  //   alignItems: "center",
  //   marginTop: "2px",
  // };

  // const pagination = {
  //   listStyle: "none",
  //   height: "31.5px",
  //   width: "31.5px",
  //   display: "flex",
  //   justifyContent: "center",
  //   alignItems: "center",
  //   marginTop: "2px",
  //   cursor: "pointer",
  // };

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
                      {list?.map((item) => {
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
                                // onClick={(e) => handleDelete(e, item.id)}
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
      <main id="main" class="main">
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
                    <h6 htmlFor="exampleFormControlSelect1">Nom</h6>
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
                    <h6 htmlFor="exampleFormControlSelect1">Email</h6>
                    <input
                      {...register("email", { required: true })}
                      type="text"
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
                        Ce champ est obligatoire
                      </span>
                    )}
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
