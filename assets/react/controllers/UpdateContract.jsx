import React from "react";
import { useState, useEffect, useRef, memo, useId, Suspense } from "react";
import { useForm } from "react-hook-form";
import axios from "axios";

function UpdateContract(props) {
  const [selectedItem, setSelectedItem] = useState(null);
  const [loading, setLoading] = useState(false);
  const [list, setList] = useState(null);

  ////----------STATE UPDATE----------////
  // const recurrenceInputRef = useRef(null);

  /*########################  REF  ########################*/
  const contractRef = useRef(null);
  const contractNameRef = useRef(null);

  const token = localStorage.getItem("token");

  useEffect(() => {
    axios
      .request({
        headers: {
          Authorization: `Bearer ${token}`,
        },
        method: "GET",
        url: `https://localhost:8000/api/contracts`,
      })
      .then((res) => {
        const contractsData = res.data["hydra:member"];

        setList(contractsData);
        setLoading(true);
      })
      .catch((err) => console.log(err));
  }, []);

  /*######################## RECHERCHE DU CONTRAT  ########################*/
  const getProps = () => {
    const contractId = props.idContract;
    const refContractId = contractId;

    let findContract;

    if (list !== null || undefined) {
      findContract = list.find((el) => {
        return el.id == contractId;
      });
      setSelectedItem(findContract);
    }
    setLoading(true);
    contractNameRef.current = "allan";
    console.log(contractNameRef.current);
  };

  const handleClean = () => {
    setSelectedItem(null);
    contractNameRef.current = null;
  };

  ////----------------------VALIDATION FORM------------------------////

  const { register, handleSubmit, formState, setValue } = useForm({});

  const { errors } = formState;

  if (selectedItem) {
    console.log(selectedItem);
    console.log(contractNameRef.current);
  }

  return (
    <>
      <button
        type="button"
        className="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#basicModals"
        onClick={getProps}
      >
        <i class="bi bi-pencil"></i>
      </button>

      <div class="modal fade" id="basicModals" tabIndex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Basic Modal</h5>
              <button
                type="button"
                class="btn-close dismiss-btn"
                data-bs-dismiss="modal"
                aria-label="Close"
                onClick={handleClean}
              ></button>
            </div>
            <div class="modal-body">
              <ul className="list-group list-group-flush">
                <li className="list-group-item">
                  <h6 htmlFor="exampleFormControlSelect1">reference</h6>
                  <input
                    type="text"
                    className="form-control"
                    id="exampleFormControlInput1"
                    // ref={titleInputRef}
                    // defaultValue={}
                  />
                </li>
                <li className="list-group-item">
                  <h6 htmlFor="exampleFormControlSelect1">name</h6>
                  <input
                    type="text"
                    className="form-control"
                    id="exampleFormControlInput1"
                    // ref={titleInputRef}
                    defaultValue={contractNameRef.current}
                  />
                </li>
              </ul>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
              >
                Close
              </button>
              <button type="button" class="btn btn-primary">
                Save changes
              </button>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}

const SuspendedUpdateContract = (props) => (
  <Suspense fallback={<div>Loading...</div>}>
    <UpdateContract />
  </Suspense>
);

export default memo(UpdateContract);
