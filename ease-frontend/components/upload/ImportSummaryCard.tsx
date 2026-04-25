"use client";

import { CheckCircle2, Download, AlertTriangle } from "lucide-react";
import { ImportResponse } from "@/lib/types";

interface Props {
  result: ImportResponse;
}

export default function ImportSummaryCard({ result }: Props) {
  return (
    <div className="bg-white border border-slate-100 rounded-3xl shadow-xl shadow-slate-200/50 overflow-hidden animate-in fade-in slide-in-from-bottom-4 duration-500">
      <div className="bg-green-500 p-6 flex items-center gap-3 text-white">
        <CheckCircle2 className="w-8 h-8" />
        <div>
          <h3 className="text-xl font-bold">Import Complete</h3>
          <p className="text-green-100 text-sm">Data has been processed successfully</p>
        </div>
      </div>
      
      <div className="p-8 grid grid-cols-2 md:grid-cols-4 gap-8">
        <div className="space-y-1">
          <p className="text-sm text-slate-500 uppercase font-bold tracking-wider">Total Rows</p>
          <p className="text-3xl font-black text-slate-900">{result.total.toLocaleString()}</p>
        </div>
        <div className="space-y-1">
          <p className="text-sm text-slate-500 uppercase font-bold tracking-wider">Inserted</p>
          <p className="text-3xl font-black text-green-600">{result.inserted.toLocaleString()}</p>
        </div>
        <div className="space-y-1">
          <p className="text-sm text-slate-500 uppercase font-bold tracking-wider text-orange-500">Duplicates</p>
          <p className="text-3xl font-black text-orange-500">{result.skipped_duplicate.toLocaleString()}</p>
        </div>
        <div className="space-y-1">
          <p className="text-sm text-slate-500 uppercase font-bold tracking-wider text-red-500">Invalid</p>
          <p className="text-3xl font-black text-red-500">{result.skipped_invalid.toLocaleString()}</p>
        </div>
      </div>

      {result.error_log_url && (
        <div className="px-8 pb-8">
          <div className="bg-slate-50 border border-slate-200 rounded-2xl p-4 flex items-center justify-between">
            <div className="flex items-center gap-3 text-slate-600 text-sm">
              <AlertTriangle className="w-5 h-5 text-orange-500" />
              <span>Some rows were skipped due to formatting errors.</span>
            </div>
            <a 
              href={result.error_log_url} 
              target="_blank" 
              className="flex items-center gap-2 bg-white border border-slate-200 px-4 py-2 rounded-xl text-sm font-bold text-slate-700 hover:bg-slate-100 transition-colors"
            >
              <Download className="w-4 h-4" />
              Download Error Log
            </a>
          </div>
        </div>
      )}
    </div>
  );
}
