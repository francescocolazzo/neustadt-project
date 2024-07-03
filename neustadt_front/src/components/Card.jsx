import React, { useState } from "react";
import { faEye, faTrash } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import ImageModal from "./ImageModal/ImageModal";

const Card = ({ card, onDelete }) => {
  const uri = !card.path.includes("https") ? `http://localhost:8001` : "";
  const [isShowed, SetShowed] = useState(false);
  const handleShowImg = () => {
    SetShowed(!isShowed);
  };

  const handleDelete = () => {
    onDelete(card.id);
  };

  return (
    <div className="border rounded shadow-md p-4 pb-2 pt-2 d-flex flex-col">
      <h4 className="text-lg font-bold pt-2 " style={{ height: "18%" }}>
        {card.name}
      </h4>

      <img
        src={`${uri}${card.path}`}
        alt={card.name}
        className="w-full h-auto"
      />
      <div className="d-flex  pb-2 pt-3 justify-between">
        <button
          className="btn btn-dark"
          style={{
            display: "flex",
            alignItems: "center",
            justifyContent: "center",
          }}
          onClick={handleShowImg}
        >
          <FontAwesomeIcon icon={faEye} />
        </button>

        <button
          className="btn btn-outline-dark"
          style={{
            display: "flex",
            alignItems: "center",
            justifyContent: "center",
          }}
          onClick={handleDelete}
        >
          <FontAwesomeIcon icon={faTrash} />
        </button>
      </div>
      <ImageModal
        show={isShowed}
        onHide={() => SetShowed(!isShowed)}
        scryfallId={`${card.scryfall_card_id}`}
      />
    </div>
  );
};

export default Card;
