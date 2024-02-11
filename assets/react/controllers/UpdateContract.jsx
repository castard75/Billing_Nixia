import React from "react";
import { memo, useState } from "react";

function UpdateContract(props) {
  const getProps = () => {
    console.log(props);
  };
  return (
    <>
      <button
        type="button"
        class="btn btn-primary"
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
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
              Non omnis incidunt qui sed occaecati magni asperiores est
              mollitia. Soluta at et reprehenderit. Placeat autem numquam et
              fuga numquam. Tempora in facere consequatur sit dolor ipsum.
              Consequatur nemo amet incidunt est facilis. Dolorem neque
              recusandae quo sit molestias sint dignissimos.
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

export default UpdateContract;
