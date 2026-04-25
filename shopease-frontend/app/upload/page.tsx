"use client";

import { useState } from "react";
import DropZone from "@/components/upload/DropZone";
import ImportSummaryCard from "@/components/upload/ImportSummaryCard";
import { ImportResponse } from "@/lib/types";
import { UploadCloud, AlertCircle } from "lucide-react";

export default function UploadPage() {
  const [result, setResult] = useState<ImportResponse | null>(null);
  const [error, setError] = useState<string | null>(null);

  return (
    <div className="max-w-4xl mx-auto space-y-8">
      <div>
        <h1 className="text-3xl font-bold text-slate-900">Import Sales Data</h1>
        <p className="text-slate-500 mt-2">Upload your wholesale sales CSV file to update the system.</p>
      </div>

      <div className="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
        <DropZone 
          onSuccess={(data) => {
            setResult(data);
            setError(null);
          }} 
          onError={(msg) => {
            setError(msg);
            setResult(null);
          }}
        />
      </div>

      {error && (
        <div className="bg-red-50 border border-red-100 p-4 rounded-2xl flex items-center gap-3 text-red-700">
          <AlertCircle className="w-5 h-5" />
          <p className="font-medium">{error}</p>
        </div>
      )}

      {result && <ImportSummaryCard result={result} />}

      <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
        <div className="bg-blue-50 p-6 rounded-2xl border border-blue-100">
          <h3 className="font-bold text-blue-900 mb-2">CSV Requirements</h3>
          <ul className="text-sm text-blue-800 space-y-1 opacity-80">
            <li>• File must be under 50MB</li>
            <li>• Column headers must match expected names</li>
            <li>• Duplicate sale_id rows will be skipped</li>
            <li>• UTF-8 encoding recommended</li>
          </ul>
        </div>
        <div className="bg-slate-50 p-6 rounded-2xl border border-slate-200">
          <h3 className="font-bold text-slate-900 mb-2">Automatic Cleaning</h3>
          <p className="text-sm text-slate-600 leading-relaxed">
            Our system automatically normalizes branch names, cleans currency symbols (৳), 
            and validates date formats (DMY, YMD, MDY) during import.
          </p>
        </div>
      </div>
    </div>
  );
}
