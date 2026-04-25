"use client";

import { useState } from "react";
import { Download, Loader2, FileText, FileSpreadsheet } from "lucide-react";
import { exportCsv, exportExcel, checkExportStatus } from "@/lib/api";
import { SaleFilters, JobResponse } from "@/lib/types";

interface Props {
  filters: SaleFilters;
}

export default function ExportControls({ filters }: Props) {
  const [loading, setLoading] = useState<"csv" | "excel" | null>(null);
  const [jobId, setJobId] = useState<string | null>(null);
  const [status, setStatus] = useState<string | null>(null);

  const handleExport = async (type: "csv" | "excel") => {
    setLoading(type);
    try {
      const apiCall = type === "csv" ? exportCsv : exportExcel;
      const response = await apiCall(filters);

      if (response instanceof Blob) {
        // Direct download
        const url = window.URL.createObjectURL(response);
        const link = document.createElement("a");
        link.href = url;
        link.setAttribute("download", `sales_export_${new Date().getTime()}.${type === "csv" ? "csv" : "xlsx"}`);
        document.body.appendChild(link);
        link.click();
        link.remove();
      } else {
        // Background job
        setJobId(response.job_id);
        setStatus("processing");
        pollStatus(response.job_id);
      }
    } catch (error) {
      console.error("Export failed", error);
      alert("Export failed. Please try again.");
    } finally {
      if (!jobId) setLoading(null);
    }
  };

  const pollStatus = async (id: string) => {
    const interval = setInterval(async () => {
      try {
        const result = await checkExportStatus(id);
        if (result.status === "ready" && result.download_url) {
          setStatus("ready");
          clearInterval(interval);
          setLoading(null);
          window.open(result.download_url, "_blank");
        } else if (result.status === "failed") {
          setStatus("failed");
          clearInterval(interval);
          setLoading(null);
        }
      } catch (err) {
        clearInterval(interval);
        setLoading(null);
      }
    }, 3000);
  };

  return (
    <div className="flex flex-col items-end gap-3">
      <div className="flex gap-4">
        <button
          onClick={() => handleExport("csv")}
          disabled={!!loading}
          className="flex items-center gap-3 bg-white border border-slate-200 px-6 py-3 rounded-2xl font-bold text-slate-700 hover:bg-slate-50 transition-all shadow-sm disabled:opacity-50"
        >
          {loading === "csv" ? (
            <Loader2 className="w-5 h-5 animate-spin" />
          ) : (
            <FileText className="w-5 h-5 text-blue-500" />
          )}
          Export CSV
        </button>

        <button
          onClick={() => handleExport("excel")}
          disabled={!!loading}
          className="flex items-center gap-3 bg-white border border-slate-200 px-6 py-3 rounded-2xl font-bold text-slate-700 hover:bg-slate-50 transition-all shadow-sm disabled:opacity-50"
        >
          {loading === "excel" ? (
            <Loader2 className="w-5 h-5 animate-spin" />
          ) : (
            <FileSpreadsheet className="w-5 h-5 text-green-500" />
          )}
          Export Excel
        </button>
      </div>

      {status === "processing" && (
        <div className="flex items-center gap-2 text-sm text-blue-600 font-bold bg-blue-50 px-4 py-2 rounded-xl animate-pulse">
          <Loader2 className="w-4 h-4 animate-spin" />
          ⏳ Preparing large export... Please wait.
        </div>
      )}
    </div>
  );
}
