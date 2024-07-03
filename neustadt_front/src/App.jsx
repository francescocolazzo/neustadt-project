import "./App.css";
import React, { useState, useEffect } from "react";
import axios from "axios";
import CustomDropdown from "./components/CustomDropdown/CustomDropdown";
import Grid from "./components/Grid";
import Button from "./components/Button";
import CustomSearch from "./components/CustomSearch";

const App = () => {
  const [sets, setSets] = useState([]);
  const [selectedCode, setSelectedSet] = useState("");
  const [objectCards, setCards] = useState([]);

  useEffect(() => {
    axios
      .get(`http://localhost:8001/api/sets`)
      .then((res) => res.data)
      .then(({ data }) => setSets(data.sets.data));
  }, []);

  return (
    <div className="container mx-auto p-4 w-100">
      <span className="text-3xl font-bold">Scryfall Cards</span>
      <hr className="mb-4 mt-2" />
      <div className="d-flex justify-between gap-4">
        <div className="w-[55%]">
          <CustomDropdown
            sets={sets}
            selectedCode={selectedCode}
            onSelectSet={setSelectedSet}
          />
        </div>

        <div className="w-[20%]">
          <Button
            className="w-full"
            code={selectedCode}
            setCards={setCards}
            onSelectSet={setSelectedSet}
          />
        </div>

        <div className="w-[25%]">
          <CustomSearch setCards={setCards} />
        </div>
      </div>

      <div className="mt-4">
        <Grid objectCards={objectCards} setCards={setCards} />
        {/* <Pagination paginationObject={objectCards.pagination} /> */}
      </div>
    </div>
  );
};

export default App;
