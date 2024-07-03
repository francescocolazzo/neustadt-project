import React, { useEffect, useState } from "react";
import "./modal.css";
import Modal from "react-bootstrap/Modal";
import axios from "axios";

export default function ImageModal(imageProps) {
  const { show, onHide, scryfallId } = imageProps;
  const [image, setImage] = useState(null);

  useEffect(() => {
    if (show) {
      const image = axios
        .get(`http://localhost:8001/api/cards/${scryfallId}`)
        .then((res) =>  setImage(res.data.data.card?.image_uris.normal));
    }
  }, [show]);

  return (
    <Modal
      show={show}
      onHide={onHide}
      size="md"
      aria-labelledby="contained-modal-title-vcenter"
      centered
    >
      <Modal.Body>
        <div
          className="modal_img"
          style={{ backgroundImage: `url(${image})` }}
        ></div>
      </Modal.Body>
    </Modal>
  );
}
