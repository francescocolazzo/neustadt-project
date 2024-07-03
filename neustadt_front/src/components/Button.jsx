import axios from "axios";
import React, { useState } from "react";
import { Button as BootstrapButton, Modal } from "react-bootstrap";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faDownload } from "@fortawesome/free-solid-svg-icons";

export default function Button({ code, setCards, onSelectSet }) {
  const [showModal, setShowModal] = useState(false);
  const [modalMessage, setModalMessage] = useState("");
  const [modalVariant, setModalVariant] = useState("success");

  const handleCloseModal = () => setShowModal(false);

  const getCards = () => {
    if (code) {
      axios
        .post(`http://localhost:8001/api/cards`, { code: code })
        .then((response) => {
          setCards(response.data.data);
          setModalMessage("Cards downloaded!");
          setModalVariant("success");
          setShowModal(true);
          onSelectSet("");
        })
        .catch((error) => {
          setModalMessage("Cards not fetched!");
          setModalVariant("danger");
          setShowModal(true);
          console.log(error);
        });
    }
  };

  return (
    <>
      <Modal show={showModal} onHide={handleCloseModal}>
        <Modal.Header closeButton>
          <Modal.Title>
            {modalVariant === "success" ? "Success" : "Error"}
          </Modal.Title>
        </Modal.Header>
        <Modal.Body>{modalMessage}</Modal.Body>
        <Modal.Footer>
          <BootstrapButton variant="outline-dark" onClick={handleCloseModal}>
            Close
          </BootstrapButton>
        </Modal.Footer>
      </Modal>

      <BootstrapButton
        variant="outline-dark"
        onClick={getCards}
      >
        <div className="d-flex justify-between align-items-baseline gap-2">
          <FontAwesomeIcon icon={faDownload} style={{ fontSize: "100%" }} />
          Get Cards
        </div>
      </BootstrapButton>
    </>
  );
}
