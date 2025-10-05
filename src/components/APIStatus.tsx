import * as React from "react";
import axios from "axios";

const base = import.meta.env.DEV
  ? `${import.meta.env.VITE_API_URL}/api` // বা dev proxy নিলে "/api"
  : `${import.meta.env.VITE_API_URL}/api`;

export const APIStatus: React.FC = () => {
  const [msg, setMsg] = React.useState("Checking...");
  const check = async () => {
    try {
      const res = await axios.get(`${base}/ping`, {
        headers: { "Cache-Control": "no-cache" },
      });
      setMsg(`OK ✅  time=${res.data?.time ?? "n/a"}`);
    } catch (e: any) {
      setMsg(`FAIL ❌  ${e?.message || "Error"}`);
      console.error(e);
    }
  };

  React.useEffect(() => { void check(); }, []);

  return (
    <div style={{ padding: 8, border: "1px solid #ddd", borderRadius: 8 }}>
      <b>API Status:</b> {msg}
      <button onClick={check} style={{ marginLeft: 12 }}>Recheck</button>
    </div>
  );
};
