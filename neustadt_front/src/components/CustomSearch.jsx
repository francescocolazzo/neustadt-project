
import axios from "axios";
import React, { useEffect, useState } from "react";

const CustomSearch = ( {setCards}) => {
  const [searchTerm, setSearchTerm] = useState("");

  useEffect(() => {
    if (searchTerm) {
      axios
        .get(`http://localhost:8001/api/cards?name=${searchTerm}`)
        .then((res) => res.data)
        .then(({ data }) => {
          setCards(data)

          setTimeout(() => {
            setSearchTerm("");
          }, 4000);
        })
        .catch((error) => {
          console.error("Error fetching cards:", error);
          setCards([]);
        });
    }
  }, [searchTerm]);

  return (
    <>
      <input 
        type="text"
        className="form-control border-1 border-dark"
        placeholder="Search cards by name..."
        value={searchTerm}
      
        onChange={(e) => setSearchTerm(e.target.value)}
      />
    </>
  );
};

export default CustomSearch;